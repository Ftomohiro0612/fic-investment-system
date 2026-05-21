#!/usr/bin/env node
// Read a single tab's cell values from a Google Sheet using a service-account JSON key.
// Read-only (values.get). Mirrors the auth pattern of update_sheet_row.mjs:
// the key is read at runtime via fs and its contents never appear in stdout.
//
// Usage:
//   node scripts/sheets/read_sheet_tab.mjs \
//     --key "C:/path/to/service-account.json" \
//     --sheet-id 1ExBSpP3-QMN2gmh9qswp986LKDKXzsWfjzl78DCDoUg \
//     --tab "v3_ステータス定義" \
//     [--range "A1:D50"]   # optional A1 range within the tab; default = whole tab
//
// Output: tab-separated rows to stdout (cell values only). No key material is printed.

import fs from 'node:fs';
import crypto from 'node:crypto';

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

async function getValues(sheetId, token, a1) {
  const url = `https://sheets.googleapis.com/v4/spreadsheets/${sheetId}/values/${encodeURIComponent(a1)}`;
  const res = await fetch(url, { headers: { Authorization: `Bearer ${token}` } });
  const json = await res.json();
  if (!res.ok) {
    throw new Error(`values.get failed: ${res.status} ${JSON.stringify(json)}`);
  }
  return json.values || [];
}

async function main() {
  const args = parseArgs(process.argv);
  const keyPath = args.key || process.env.GOOGLE_APPLICATION_CREDENTIALS;
  if (!keyPath) throw new Error('Set --key or GOOGLE_APPLICATION_CREDENTIALS');
  const sheetId = args['sheet-id'];
  const tab = args.tab;
  if (!sheetId) throw new Error('Missing --sheet-id');
  if (!tab) throw new Error('Missing --tab');

  const a1 = args.range ? `${tab}!${args.range}` : tab;

  const token = await getAccessToken(keyPath, [
    'https://www.googleapis.com/auth/spreadsheets.readonly',
  ]);
  const rows = await getValues(sheetId, token, a1);
  console.log(`[read OK] ${a1}: ${rows.length} row(s)`);
  rows.forEach((r, i) => {
    console.log(`${String(i + 1).padStart(3, ' ')} | ${r.join('\t')}`);
  });
}

main().catch((err) => {
  console.error('[ERROR]', err.message || err);
  process.exit(1);
});
