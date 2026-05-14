#!/usr/bin/env node
// Update Google Sheets cells for a FIC company-analysis row using a service-account JSON key.
//
// Usage:
//   node scripts/sheets/update_sheet_row.mjs \
//     --key "C:/path/to/service-account.json" \
//     --sheet-id 1ExBSpP3-QMN2gmh9qswp986LKDKXzsWfjzl78DCDoUg \
//     --tab "企業分析_旧列順控え" \
//     --row 17 \
//     --memo work/company_analysis/5019_idemitsu/claude_integrated_memo.md \
//     --article work/company_analysis/5019_idemitsu/claude_article.html \
//     --date 2026-05-14 \
//     --status "Claude記事作成済み"
//
//   Add --dry-run to only verify read access without writing.
//
// Cell mapping (defaults; override with --memo-col / --article-col / --date-col / --status-col):
//   --memo-col    (default AD) = 統合分析メモ
//   --article-col (default AM) = HTML本文
//   --date-col    (default AL) = 作業日
//   --status-col  (default AO) = ステータス
//   --review-col            = レビューメモ列（任意。指定時のみ書き込み）
//   --action-col            = 次アクション列（任意。指定時のみ書き込み）
//
// Sheet 企業分析 (v3 main, FIC記事管理_v3) uses: --memo-col AB --article-col AD --date-col AA
// Sheet 企業分析_旧列順控え uses defaults: memo AD, article AM, date AL, status AO
//
// ## モード（--path-mode 推奨・新標準）
//
// --path-mode が指定された場合、memo / article 列に「ファイル内容」ではなく
// 「ファイルパス文字列」を書き込む。リポジトリを真実のソースとし、シートには
// パス＋ステータスのみ記録する運用（仕様書1.2章準拠）。
//
// 互換動作（既定）: --path-mode が未指定なら従来通りファイル内容を書き込む。

import fs from 'node:fs';
import crypto from 'node:crypto';
import path from 'node:path';

function parseArgs(argv) {
  const out = { _flags: new Set() };
  for (let i = 2; i < argv.length; i++) {
    const a = argv[i];
    if (a.startsWith('--')) {
      const key = a.slice(2);
      const next = argv[i + 1];
      if (next === undefined || next.startsWith('--')) {
        out._flags.add(key);
      } else {
        out[key] = next;
        i++;
      }
    }
  }
  return out;
}

function base64url(buf) {
  return Buffer.from(buf).toString('base64')
    .replace(/=+$/, '').replace(/\+/g, '-').replace(/\//g, '_');
}

async function getAccessToken(keyPath, scopes) {
  const key = JSON.parse(fs.readFileSync(keyPath, 'utf8'));
  const now = Math.floor(Date.now() / 1000);
  const header = { alg: 'RS256', typ: 'JWT' };
  const claim = {
    iss: key.client_email,
    scope: scopes.join(' '),
    aud: 'https://oauth2.googleapis.com/token',
    iat: now,
    exp: now + 3600,
  };
  const signingInput = `${base64url(JSON.stringify(header))}.${base64url(JSON.stringify(claim))}`;
  const signature = crypto.sign('RSA-SHA256', Buffer.from(signingInput), key.private_key);
  const jwt = `${signingInput}.${base64url(signature)}`;

  const body = new URLSearchParams({
    grant_type: 'urn:ietf:params:oauth:grant-type:jwt-bearer',
    assertion: jwt,
  });
  const res = await fetch('https://oauth2.googleapis.com/token', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body,
  });
  const json = await res.json();
  if (!res.ok) {
    throw new Error(`Token exchange failed: ${res.status} ${JSON.stringify(json)}`);
  }
  return json.access_token;
}

async function getSheetTitles(sheetId, token) {
  const url = `https://sheets.googleapis.com/v4/spreadsheets/${sheetId}?fields=sheets.properties.title`;
  const res = await fetch(url, { headers: { Authorization: `Bearer ${token}` } });
  const json = await res.json();
  if (!res.ok) {
    throw new Error(`Sheets metadata failed: ${res.status} ${JSON.stringify(json)}`);
  }
  return (json.sheets || []).map((s) => s.properties.title);
}

function rangeFor(tab, col, row) {
  const escaped = tab.replace(/'/g, "''");
  return `'${escaped}'!${col}${row}`;
}

async function batchUpdate(sheetId, token, data) {
  const url = `https://sheets.googleapis.com/v4/spreadsheets/${sheetId}/values:batchUpdate`;
  const body = {
    valueInputOption: 'RAW',
    data: data.map((d) => ({ range: d.range, values: [[d.value]] })),
  };
  const res = await fetch(url, {
    method: 'POST',
    headers: {
      Authorization: `Bearer ${token}`,
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(body),
  });
  const json = await res.json();
  if (!res.ok) {
    throw new Error(`batchUpdate failed: ${res.status} ${JSON.stringify(json)}`);
  }
  return json;
}

function readFileOrThrow(label, p) {
  if (!p) throw new Error(`Missing --${label}`);
  const abs = path.resolve(p);
  if (!fs.existsSync(abs)) throw new Error(`${label} not found: ${abs}`);
  return fs.readFileSync(abs, 'utf8');
}

async function main() {
  const args = parseArgs(process.argv);
  const keyPath = args.key || process.env.GOOGLE_APPLICATION_CREDENTIALS;
  if (!keyPath) throw new Error('Set --key or GOOGLE_APPLICATION_CREDENTIALS');

  const sheetId = args['sheet-id'];
  const tab = args.tab || '企業分析_旧列順控え';
  const row = args.row;
  if (!sheetId) throw new Error('Missing --sheet-id');
  if (!row) throw new Error('Missing --row');

  const dryRun = args._flags.has('dry-run');
  const pathMode = args._flags.has('path-mode');

  // path-mode: write the path string itself (do not read file content).
  // content-mode (default): read the file and write its contents.
  let memo, article;
  if (dryRun) {
    memo = null;
    article = null;
  } else if (pathMode) {
    if (!args.memo) throw new Error('Missing --memo (path string required in --path-mode)');
    if (!args.article) throw new Error('Missing --article (path string required in --path-mode)');
    // Verify files exist so we don't write a broken path
    if (!fs.existsSync(path.resolve(args.memo))) throw new Error(`memo file not found: ${args.memo}`);
    if (!fs.existsSync(path.resolve(args.article))) throw new Error(`article file not found: ${args.article}`);
    memo = args.memo;
    article = args.article;
  } else {
    memo = readFileOrThrow('memo', args.memo);
    article = readFileOrThrow('article', args.article);
  }
  const date = args.date || new Date().toISOString().slice(0, 10);
  const status = args.status || 'Claude記事作成済み';
  const memoCol = args['memo-col'] || 'AD';
  const articleCol = args['article-col'] || 'AM';
  const dateCol = args['date-col'] || 'AL';
  const statusCol = args['status-col'] || 'AO';
  const reviewCol = args['review-col'];
  const actionCol = args['action-col'];
  const review = args.review;
  const action = args.action;
  const skipStatus = args._flags.has('skip-status');
  const skipDate = args._flags.has('skip-date');

  const token = await getAccessToken(keyPath, [
    'https://www.googleapis.com/auth/spreadsheets',
  ]);

  const titles = await getSheetTitles(sheetId, token);
  const hasTab = titles.includes(tab);
  console.log(`[read OK] tabs: ${titles.join(' | ')}`);
  console.log(`[tab match] ${tab}: ${hasTab ? 'found' : 'NOT FOUND'}`);
  if (!hasTab) throw new Error(`Tab "${tab}" not found in spreadsheet`);

  if (dryRun) {
    console.log('[dry-run] skipping write');
    return;
  }

  const data = [
    { range: rangeFor(tab, memoCol, row),    value: memo,    label: `${memoCol} memo${pathMode ? ' [path]' : ''}` },
    { range: rangeFor(tab, articleCol, row), value: article, label: `${articleCol} article${pathMode ? ' [path]' : ''}` },
  ];
  if (!skipDate) {
    data.push({ range: rangeFor(tab, dateCol, row), value: date, label: `${dateCol} date` });
  }
  if (!skipStatus) {
    data.push({ range: rangeFor(tab, statusCol, row), value: status, label: `${statusCol} status` });
  }
  if (reviewCol && review) {
    data.push({ range: rangeFor(tab, reviewCol, row), value: review, label: `${reviewCol} review` });
  }
  if (actionCol && action) {
    data.push({ range: rangeFor(tab, actionCol, row), value: action, label: `${actionCol} action` });
  }
  for (const d of data) {
    console.log(`[write] ${d.label}: range=${d.range}, len=${(d.value || '').length}`);
  }
  const result = await batchUpdate(sheetId, token, data);
  console.log(`[done] totalUpdatedCells=${result.totalUpdatedCells} mode=${pathMode ? 'path' : 'content'}`);
}

main().catch((err) => {
  console.error('[ERROR]', err.message || err);
  process.exit(1);
});
