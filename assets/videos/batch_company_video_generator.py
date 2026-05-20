import argparse
import asyncio
import json
import math
import os
import re
import shutil
import subprocess
import sys
from pathlib import Path

ROOT = Path(__file__).resolve().parents[2]
PYDEPS = ROOT / "work" / "company_analysis" / "3861_oji" / "video" / "_pydeps"
sys.path.insert(0, str(PYDEPS))

import edge_tts
import imageio.v2 as imageio
import imageio_ffmpeg
import numpy as np
from mutagen.mp3 import MP3
from PIL import Image, ImageDraw, ImageEnhance, ImageFilter, ImageFont


TARGETS = [
    {
        "folder": "3863_nippon_paper",
        "code": "3863",
        "company": "日本製紙",
        "full_name": "日本製紙",
        "slug": "nippon-paper-3863",
        "article_url": "https://fic-investment.biz/nippon-paper-3863-analysis/",
        "theme": "紙の縮小ではなく、生活関連・木材バイオマスへの転換を買う",
        "hook": "日本製紙は、\n紙の会社のままで\n読めるのか？",
        "one_liner": "斜陽の洋紙から、生活関連・木材バイオマスへ利益源を移せるかを見る銘柄。",
        "not_only": "日本製紙 ≠ 紙需要の復活だけ",
        "short_takeaway": "生活関連・木材バイオマスへの転換を見る",
        "drivers": ["生活関連の黒字化", "木材・バイオマス", "ROE改善"],
        "checks": ["生活関連利益", "紙・板紙の構造改革", "ROE 8%への距離"],
        "risk": "洋紙縮小が速く、転換利益が追いつかないこと",
        "metric_slide": {
            "title": "中計2030で見る山場",
            "headline": "営業利益を2倍超へ",
            "from": "252億円",
            "to": "600億円以上",
            "note": "生活関連・木材バイオマス・構造改革が同時に効くか"
        },
        "driver_notes": [
            "家庭紙・包装・ケミカルなど、紙以外の利益源が主役になれるか。",
            "社有林、木材、バイオマスを、単なる資産でなく収益源に変えられるか。",
            "低い資本効率が改善し、株式市場の見方が変わるか。"
        ],
        "profit_cards": [
            ("需要の置き換え", "洋紙は縮小。家庭紙・包装・木質素材へ売上の軸を移す。"),
            ("利益率の回復", "価格修正と構造改革で、数量減を利益改善に変えられるか。"),
            ("再評価の条件", "ROE 8%へ近づくほど、斜陽株ではなく転換株として見られる。")
        ],
        "check_notes": [
            "生活関連が黒字を積み上げ、紙の落ち込みを補えているか。",
            "紙・板紙の固定費削減が、利益に実際に出ているか。",
            "営業利益だけでなくROE改善まで進んでいるか。"
        ],
        "colors": [(37, 114, 100), (211, 168, 46), (35, 80, 128)],
        "bg_keywords": "forest biomass paper mill tissue packaging",
    },
    {
        "folder": "5602_kurimoto",
        "code": "5602",
        "company": "栗本鐵工所",
        "full_name": "栗本鐵工所",
        "slug": "kurimoto-5602",
        "article_url": "https://fic-investment.biz/kurimoto-5602-analysis/",
        "theme": "老朽インフラ更新と産業設備の二本柱を買う",
        "hook": "栗本鐵工所は、\n地味な鉄管株だけで\n終わるのか？",
        "one_liner": "上下水道の更新需要を土台に、次期中計でROE 8%超へ進めるかを見る銘柄。",
        "not_only": "栗本鐵工所 ≠ 鉄管だけ",
        "short_takeaway": "老朽インフラ更新と産業設備を見る",
        "drivers": ["水道インフラ更新", "機械システムの採算", "ROE 8%への階段"],
        "checks": ["官需の受注", "営業利益率", "次期中計の目標"],
        "risk": "公共投資の遅れや鋼材高で利益率が押されること",
        "metric_slide": {
            "title": "中計2026は実質達成済み",
            "headline": "次はROE 8%超への階段",
            "from": "営業利益80.6億円",
            "to": "次期中計",
            "note": "官需の安定に、機械システム回復を上乗せできるか"
        },
        "driver_notes": [
            "老朽化した上下水道の更新が、長期の受注土台になるか。",
            "産業設備・機械の採算が、鉄管依存の評価を変えられるか。",
            "中計達成後も、ROE 8%超を維持できる資本効率へ進めるか。"
        ],
        "profit_cards": [
            ("官需の安定", "水道管更新は派手さはないが、需要の底を作る。"),
            ("民需の上乗せ", "機械システムが利益率を押し上げると評価が変わる。"),
            ("次期中計", "目標更新が保守的なら評価は伸びにくい。強い目標なら再評価余地。")
        ],
        "check_notes": [
            "官公庁向けの受注残が積み上がっているか。",
            "鋼材高を価格転嫁し、営業利益率を守れているか。",
            "次期中計でROEと成長投資の両方が示されるか。"
        ],
        "colors": [(42, 92, 132), (211, 168, 46), (92, 112, 122)],
        "bg_keywords": "water pipes infrastructure factory steel",
    },
    {
        "folder": "5929_sanwa",
        "code": "5929",
        "company": "三和HD",
        "full_name": "三和ホールディングス",
        "slug": "sanwa-holdings-5929",
        "article_url": "https://fic-investment.biz/sanwa-holdings-5929-analysis/",
        "theme": "日米欧アジア分散とROIC経営を買う",
        "hook": "三和HDは、\nシャッターだけで\n読んでいいのか？",
        "one_liner": "地域分散と高機能開口部の利益率改善が、資本効率を押し上げるかを見る銘柄。",
        "not_only": "三和HD ≠ シャッターだけ",
        "short_takeaway": "地域分散とROIC経営を見る",
        "drivers": ["4地域分散", "価格転嫁力", "ROIC経営"],
        "checks": ["米州利益率", "欧州・アジア改善", "鋼材・関税影響"],
        "risk": "米州関税や低収益地域が中計目標の重しになること",
        "metric_slide": {
            "title": "10年で利益率が変化",
            "headline": "営業利益率が大きく改善",
            "from": "7.3%",
            "to": "12.0%",
            "note": "価格転嫁・高機能商品・M&Aで稼ぐ力を上げた"
        },
        "driver_notes": [
            "日本だけでなく米州・欧州・アジアの分散で成長を拾う。",
            "鋼材高や人件費を価格へ反映できるかが利益率を決める。",
            "ROIC経営で、売上拡大より稼ぐ力を重視する会社へ変わるか。"
        ],
        "profit_cards": [
            ("地域分散", "米州が強く、日本・欧州・アジア改善が上乗せになる。"),
            ("単価と原価", "シャッターやドアは価格転嫁力が利益率を左右する。"),
            ("資本効率", "ROICを上げられると、建材株ではなく高効率企業として見られる。")
        ],
        "check_notes": [
            "米州の利益率が高水準を維持しているか。",
            "欧州・アジアが赤字や低採算から改善しているか。",
            "鋼材価格や関税の影響を価格で吸収できているか。"
        ],
        "colors": [(33, 88, 122), (211, 168, 46), (90, 120, 140)],
        "bg_keywords": "industrial doors shutters logistics warehouse",
    },
    {
        "folder": "6098_recruit",
        "code": "6098",
        "company": "リクルートHD",
        "full_name": "リクルートホールディングス",
        "slug": "recruit-holdings-6098",
        "article_url": "https://fic-investment.biz/recruit-holdings-6098-analysis/",
        "theme": "Indeed中心のHRテック再成長と資本配分を買う",
        "hook": "リクルートHDは、\n人材株なのか、\nAI時代の求人基盤なのか？",
        "one_liner": "求人市場の循環を受けながら、Indeedの単価改善と効率投資で再成長できるかを見る銘柄。",
        "not_only": "リクルートHD ≠ 人材株だけ",
        "short_takeaway": "HRテック再成長と資本配分を見る",
        "drivers": ["HRテック需要", "Indeed単価改善", "株主還元と投資"],
        "checks": ["米国求人市場", "Indeed売上成長", "販管費効率"],
        "risk": "求人市況の弱さが長引き、成長投資の回収が遅れること",
        "metric_slide": {
            "title": "HR Techの再加速",
            "headline": "中期で20%超成長を狙う",
            "from": "FY25 +14.5%",
            "to": "20%超",
            "note": "IndeedのAIマッチングと単価改善が鍵"
        },
        "driver_notes": [
            "求人市場が底打ちすると、HRテックの売上回復が見えやすい。",
            "Indeedが応募の質や単価を上げられるかが成長の芯になる。",
            "高い還元とAI投資を両立できるかが評価を左右する。"
        ],
        "profit_cards": [
            ("求人循環", "採用需要が戻ると、Indeedの売上回復が先に出やすい。"),
            ("単価改善", "AIマッチングで成果価値が上がれば、売上だけでなく利益率にも効く。"),
            ("資本配分", "投資・還元・利益成長のバランスが崩れないかを見る。")
        ],
        "check_notes": [
            "米国求人件数と採用意欲が底打ちしているか。",
            "Indeedの売上が数量だけでなく単価面でも改善しているか。",
            "販管費が増えすぎず、利益成長に戻っているか。"
        ],
        "colors": [(30, 94, 150), (211, 168, 46), (50, 120, 145)],
        "bg_keywords": "digital recruitment data platform office",
    },
    {
        "folder": "8411_mizuho_fg",
        "code": "8411",
        "company": "みずほFG",
        "full_name": "みずほフィナンシャルグループ",
        "slug": "mizuho-fg-8411",
        "article_url": "https://fic-investment.biz/mizuho-fg-8411-analysis/",
        "theme": "金利ある世界での利ざや改善と資本効率を買う",
        "hook": "みずほFGは、\n金利上昇だけで\n買えるのか？",
        "one_liner": "金利追い風だけでなく、与信費用と資本効率を同時に確認する銀行株。",
        "not_only": "みずほFG ≠ 金利上昇だけ",
        "short_takeaway": "利ざや改善と資本効率を見る",
        "drivers": ["国内金利", "貸出・預金利ざや", "与信費用と還元"],
        "checks": ["預貸金利差", "与信費用", "ROEと株主還元"],
        "risk": "金利メリットより信用コストや市場変動が大きくなること",
        "metric_slide": {
            "title": "金利ある世界の効果",
            "headline": "ROEは目標を前倒し達成",
            "from": "5.1%",
            "to": "11.4%",
            "note": "資金利益・政策株売却・非金利収益が同時に効いた"
        },
        "driver_notes": [
            "金利上昇は追い風だが、どの預金・貸出に効くかを見る。",
            "利ざや改善が本業利益を押し上げるかが銀行株の中心。",
            "与信費用が増えると金利メリットを打ち消すため、還元余力も確認する。"
        ],
        "profit_cards": [
            ("金利追い風", "国内金利が上がると貸出収益が改善しやすい。"),
            ("信用コスト", "不良債権や与信費用が増えると利益を削る。"),
            ("還元余力", "ROE改善と増配・自社株買いが続くかで評価が変わる。")
        ],
        "check_notes": [
            "預貸金利差が実際に拡大しているか。",
            "与信費用が想定内に収まり、利益を削りすぎていないか。",
            "ROE改善と株主還元がセットで進んでいるか。"
        ],
        "colors": [(20, 76, 132), (211, 168, 46), (120, 40, 60)],
        "bg_keywords": "financial district bank yen interest rate",
    },
    {
        "folder": "9449_gmo_internet",
        "code": "9449",
        "company": "GMOインターネット",
        "full_name": "GMOインターネットグループ",
        "slug": "gmo-internet-9449",
        "article_url": "https://fic-investment.biz/gmo-internet-9449-analysis/",
        "theme": "ネットインフラの岩盤利益と金融市況のオプションを買う",
        "hook": "GMOは、\nネット企業なのか、\n金融市況株なのか？",
        "one_liner": "安定したインフラ収益を土台に、金融・暗号資産市況の振れをどう扱うかを見る銘柄。",
        "not_only": "GMO ≠ ネット企業だけ",
        "short_takeaway": "岩盤利益と金融市況を見る",
        "drivers": ["インフラの継続収益", "金融・暗号資産市況", "広告・メディア"],
        "checks": ["インフラ利益", "金融市況", "セキュリティ投資"],
        "risk": "金融市況の悪化や競争激化で、安定利益の評価が薄れること",
        "metric_slide": {
            "title": "利益の柱を分解",
            "headline": "インフラが全社利益の柱",
            "from": "405億円",
            "to": "全社571億円",
            "note": "金融・暗号資産は上振れ要因だが、市況で振れる"
        },
        "driver_notes": [
            "ドメイン、サーバー、決済などの継続収益が評価の土台。",
            "金融・暗号資産は上振れ要因だが、利益の振れも大きい。",
            "広告・メディアとセキュリティ投資が、次の成長余地を作れるか。"
        ],
        "profit_cards": [
            ("岩盤利益", "ネットインフラは継続課金が多く、利益の土台になりやすい。"),
            ("市況オプション", "金融・暗号資産は伸びる時は強いが、悪化時の反動も大きい。"),
            ("成長投資", "セキュリティや広告の投資が、将来利益に変わるかを見る。")
        ],
        "check_notes": [
            "インフラ事業の利益が安定成長しているか。",
            "金融・暗号資産市況の変動を過大評価していないか。",
            "セキュリティ投資が費用だけでなく売上成長に結びつくか。"
        ],
        "colors": [(30, 88, 138), (211, 168, 46), (46, 128, 112)],
        "bg_keywords": "internet data center cybersecurity finance",
    },
    {
        "folder": "9627_ain",
        "code": "9627",
        "company": "アインHD",
        "full_name": "アインホールディングス",
        "slug": "ain-holdings-9627",
        "article_url": "https://fic-investment.biz/ain-holdings-9627-analysis/",
        "theme": "さくら薬局買収後の規模拡大とPMIを買う",
        "hook": "アインHDは、\n薬局の数だけで\n読めるのか？",
        "one_liner": "さくら薬局買収で大きくなった後、PMIとリテール利益を実行できるかを見る銘柄。",
        "not_only": "アインHD ≠ 薬局数だけ",
        "short_takeaway": "規模拡大とPMIを見る",
        "drivers": ["処方箋枚数", "さくら薬局PMI", "リテール利益率"],
        "checks": ["統合コスト", "薬価・調剤改定", "薬剤師人件費"],
        "risk": "買収後の統合費用や制度改定が、利益率を押し下げること",
        "metric_slide": {
            "title": "さくら薬局で規模が変わる",
            "headline": "売上7,000億円が前倒し視野",
            "from": "6,460億円計画",
            "to": "7,000億円目標",
            "note": "買収後はPMIと自己資本比率の回復が焦点"
        },
        "driver_notes": [
            "調剤薬局は処方箋枚数と単価が売上の土台になる。",
            "さくら薬局のPMIで、規模拡大を利益に変えられるかを見る。",
            "リテール事業が利益率を補えると、薬局一本足の評価が変わる。"
        ],
        "profit_cards": [
            ("規模拡大", "店舗数と処方箋枚数は売上の土台。ただし利益化が重要。"),
            ("PMI", "さくら薬局買収後の統合費用を抑え、シナジーを出せるか。"),
            ("リテール", "コスメ・雑貨の利益率が、調剤報酬改定リスクを補えるか。")
        ],
        "check_notes": [
            "統合コストが一時的で、利益改善に向かっているか。",
            "薬価・調剤報酬改定の影響を吸収できているか。",
            "薬剤師人件費が利益率を圧迫しすぎていないか。"
        ],
        "colors": [(37, 126, 104), (211, 168, 46), (110, 70, 130)],
        "bg_keywords": "pharmacy healthcare retail cosmetics",
    },
    {
        "folder": "9843_nitori",
        "code": "9843",
        "company": "ニトリHD",
        "full_name": "ニトリホールディングス",
        "slug": "nitori-9843",
        "article_url": "https://fic-investment.biz/nitori-9843-analysis/",
        "theme": "製造物流IT小売と海外出店による再加速を買う",
        "hook": "ニトリHDは、\n安さだけで\n読めるのか？",
        "one_liner": "国内客数の回復、荒利益率、海外出店、島忠改革が同時に進むかを見る銘柄。",
        "not_only": "ニトリHD ≠ 安さだけ",
        "short_takeaway": "製造物流IT小売と海外出店を見る",
        "drivers": ["荒利益率", "海外出店", "島忠改革"],
        "checks": ["既存店客数", "為替と原価", "海外店舗の黒字化"],
        "risk": "国内消費の弱さや円安で、利益率の低下が止まらないこと",
        "metric_slide": {
            "title": "減収増益の中身",
            "headline": "荒利益率が利益を支えた",
            "from": "51.0%",
            "to": "53.2%",
            "note": "既存店の弱さを、原価低減と島忠黒字化で吸収"
        },
        "driver_notes": [
            "製造物流IT小売の強みは、荒利益率の改善に表れやすい。",
            "海外店舗が黒字化すると、国内成熟の見方が変わる。",
            "島忠改革が進めば、低採算領域の改善余地が見える。"
        ],
        "profit_cards": [
            ("荒利益率", "原価・為替・値下げの影響を吸収できるかが最重要。"),
            ("海外成長", "出店数だけでなく、店舗単位で黒字化できるかを見る。"),
            ("島忠改革", "ホームセンター領域をニトリ流の効率に近づけられるか。")
        ],
        "check_notes": [
            "既存店客数が戻り、値上げだけでない売上成長になっているか。",
            "為替と原価の悪化を荒利益率で吸収できているか。",
            "海外店舗の赤字縮小・黒字化が進んでいるか。"
        ],
        "colors": [(20, 95, 130), (211, 168, 46), (46, 126, 92)],
        "bg_keywords": "furniture retail warehouse home interior",
    },
    {
        "folder": "285A_kioxia",
        "code": "285A",
        "company": "キオクシア",
        "full_name": "キオクシアホールディングス",
        "slug": "kioxia-holdings-285a",
        "article_url": "https://fic-investment.biz/kioxia-holdings-285a-analysis/",
        "theme": "AIデータセンターSSDとNANDサイクルを買う",
        "hook": "キオクシアは、\nAIメモリ需要を\n取り込めるのか？",
        "one_liner": "AI向けSSD需要、NAND需給、BiCS/CBAのコスト低減がそろうかを見る市況連動株。",
        "not_only": "キオクシア ≠ メモリ市況だけ",
        "short_takeaway": "AI向けSSDとNANDサイクルを見る",
        "drivers": ["AI/DC向けSSD", "NAND需給・ASP", "BiCS/CBAコスト低減"],
        "checks": ["SSD売上", "ASPと供給規律", "CapEx売上比"],
        "risk": "ASP反落や過剰投資で、利益の振れ幅が大きくなること",
        "metric_slide": {
            "title": "メモリ市況の振れ幅",
            "headline": "赤字から大幅黒字へ",
            "from": "▲2,527億円",
            "to": "8,704億円",
            "note": "ASP上昇とSSD需要で営業利益が大きく振れる"
        },
        "driver_notes": [
            "AIデータセンター向けSSDが、NAND需要の主役になれるか。",
            "ASPと供給規律が崩れると、売上より利益が先に振れる。",
            "BiCS/CBAのコスト低減で、市況悪化時の耐性を作れるか。"
        ],
        "profit_cards": [
            ("需要サイクル", "AI向けSSDが伸びると、NAND市況の底上げにつながる。"),
            ("価格と規律", "ASP上昇と供給抑制がそろうと利益が大きく振れる。"),
            ("投資効率", "CapExが重すぎると、好況後の反落リスクになる。")
        ],
        "check_notes": [
            "SSD売上がAIデータセンター需要を取り込めているか。",
            "ASPと供給規律が崩れず、利益率を守れているか。",
            "CapEx売上比が過熱せず、投資回収の道筋があるか。"
        ],
        "colors": [(25, 86, 150), (211, 168, 46), (42, 138, 128)],
        "bg_keywords": "semiconductor nand memory data center chip",
    },
]


TTS_REPLACEMENTS = {
    "HD": "ホールディングス",
    "FG": "フィナンシャルグループ",
    "GMO": "ジーエムオー",
    "ROE": "アールオーイー",
    "ROIC": "アールオーアイシー",
    "PMI": "ピーエムアイ",
    "M&A": "エムアンドエー",
    "HR": "エイチアール",
    "IT": "アイティー",
    "DC": "データセンター",
    "Indeed": "インディード",
    "CapEx": "キャペックス",
    "NAND": "ナンド",
    "SSD": "エスエスディー",
    "AI": "エーアイ",
    "ASP": "エーエスピー",
    "BiCS": "ビックス",
    "CBA": "シービーエー",
    "FY": "エフワイ",
    "粗利益": "あらりえき",
    "荒利益": "あらりえき",
    "粗利率": "あらりりつ",
}


def font(size, bold=False):
    names = ["YuGothB.ttc" if bold else "YuGothM.ttc", "meiryob.ttc" if bold else "meiryo.ttc", "msgothic.ttc"]
    for name in names:
        p = Path(os.environ.get("WINDIR", "C:/Windows")) / "Fonts" / name
        if p.exists():
            return ImageFont.truetype(str(p), size)
    return ImageFont.load_default()


def wrap_text(text, max_chars):
    lines, cur = [], ""
    for ch in text:
        cur += ch
        if len(cur) >= max_chars or ch == "\n":
            if cur.strip():
                lines.append(cur.strip())
            cur = ""
    if cur.strip():
        lines.append(cur.strip())
    return lines


def text_center(draw, box, text, fnt, fill, max_chars=20, gap=8):
    x1, y1, x2, y2 = box
    lines = []
    for part in text.split("\n"):
        lines.extend(wrap_text(part, max_chars))
    sizes = [draw.textbbox((0, 0), line, font=fnt) for line in lines]
    heights = [b[3] - b[1] for b in sizes]
    total_h = sum(heights) + gap * (len(lines) - 1)
    y = y1 + (y2 - y1 - total_h) / 2
    for line, b, h in zip(lines, sizes, heights):
        w = b[2] - b[0]
        draw.text((x1 + (x2 - x1 - w) / 2, y), line, font=fnt, fill=fill)
        y += h + gap


def text_left(draw, xy, text, fnt, fill, max_chars=24, gap=8):
    x, y = xy
    for part in text.split("\n"):
        for line in wrap_text(part, max_chars):
            draw.text((x, y), line, font=fnt, fill=fill)
            b = draw.textbbox((0, 0), line, font=fnt)
            y += (b[3] - b[1]) + gap


def split_units(text):
    return re.findall(r"[A-Za-z0-9&/().%+-]+|[^\sA-Za-z0-9&/().%+-]", text)


def wrap_by_width(draw, text, fnt, max_width, max_lines=None):
    lines = []
    for paragraph in text.split("\n"):
        current = ""
        for unit in split_units(paragraph):
            candidate = current + unit
            width = draw.textbbox((0, 0), candidate, font=fnt)[2]
            if current and width > max_width:
                lines.append(current)
                current = unit
                if max_lines and len(lines) >= max_lines:
                    return lines
            else:
                current = candidate
        if current:
            lines.append(current)
            if max_lines and len(lines) >= max_lines:
                return lines
    return lines


def text_left_fit(draw, xy, text, fnt, fill, max_width, max_lines=None, gap=8):
    x, y = xy
    for line in wrap_by_width(draw, text, fnt, max_width, max_lines):
        draw.text((x, y), line, font=fnt, fill=fill)
        b = draw.textbbox((0, 0), line, font=fnt)
        y += (b[3] - b[1]) + gap
    return y


def text_center_fit(draw, box, text, fnt, fill, max_lines=None, gap=8):
    x1, y1, x2, y2 = box
    lines = wrap_by_width(draw, text, fnt, x2 - x1, max_lines)
    sizes = [draw.textbbox((0, 0), line, font=fnt) for line in lines]
    heights = [b[3] - b[1] for b in sizes]
    total_h = sum(heights) + gap * max(len(lines) - 1, 0)
    y = y1 + (y2 - y1 - total_h) / 2
    for line, b, h in zip(lines, sizes, heights):
        w = b[2] - b[0]
        draw.text((x1 + (x2 - x1 - w) / 2, y), line, font=fnt, fill=fill)
        y += h + gap


def text_left_block_fit(draw, box, text, fnt, fill, max_lines=None, gap=8):
    x1, y1, x2, y2 = box
    lines = wrap_by_width(draw, text, fnt, x2 - x1, max_lines)
    sizes = [draw.textbbox((0, 0), line, font=fnt) for line in lines]
    heights = [b[3] - b[1] for b in sizes]
    total_h = sum(heights) + gap * max(len(lines) - 1, 0)
    y = y1 + (y2 - y1 - total_h) / 2
    for line, h in zip(lines, heights):
        draw.text((x1, y), line, font=fnt, fill=fill)
        y += h + gap


def rounded(draw, box, r, fill, outline=None, width=1):
    draw.rounded_rectangle(box, radius=r, fill=fill, outline=outline, width=width)


def fit_image(path, size, bg=(246, 246, 240)):
    src = Image.open(path).convert("RGB")
    bw, bh = size
    scale = min(bw / src.width, bh / src.height)
    nw, nh = int(src.width * scale), int(src.height * scale)
    src = src.resize((nw, nh), Image.Resampling.LANCZOS)
    canvas = Image.new("RGB", (bw, bh), bg)
    canvas.paste(src, ((bw - nw) // 2, (bh - nh) // 2))
    return canvas


def cover_image(path, size, focal_x=0.5, focal_y=0.5):
    src = Image.open(path).convert("RGB")
    bw, bh = size
    scale = max(bw / src.width, bh / src.height)
    nw, nh = int(src.width * scale), int(src.height * scale)
    src = src.resize((nw, nh), Image.Resampling.LANCZOS)
    left = int((nw - bw) * focal_x)
    top = int((nh - bh) * focal_y)
    left = max(0, min(left, nw - bw))
    top = max(0, min(top, nh - bh))
    return src.crop((left, top, left + bw, top + bh))


def make_ai_background(path, size, colors, dark=False):
    portrait = size[1] > size[0]
    bg = cover_image(path, size, 0.72 if portrait else 0.58, 0.50).filter(ImageFilter.GaussianBlur(8 if dark and portrait else (3 if dark else 7)))
    if dark:
        if portrait:
            bg = ImageEnhance.Brightness(bg).enhance(0.38)
            bg = ImageEnhance.Contrast(bg).enhance(1.12)
            overlay = Image.new("RGB", size, (5, 20, 35))
            return Image.blend(bg, overlay, 0.42)
        bg = ImageEnhance.Contrast(bg).enhance(1.15)
        overlay = Image.new("RGB", size, (4, 14, 28))
        bg = Image.blend(bg, overlay, 0.46)
        shade = Image.new("RGBA", size, (0, 0, 0, 0))
        d = ImageDraw.Draw(shade, "RGBA")
        d.rectangle((0, int(size[1] * 0.72), size[0], size[1]), fill=(0, 0, 0, 76))
        return Image.alpha_composite(bg.convert("RGBA"), shade).convert("RGB")
    bg = ImageEnhance.Color(bg).enhance(0.72)
    bg = ImageEnhance.Contrast(bg).enhance(0.82)
    wash = Image.new("RGB", size, (246, 247, 241))
    bg = Image.blend(bg, wash, 0.72)
    tint = Image.new("RGBA", size, (*colors[0], 0))
    d = ImageDraw.Draw(tint, "RGBA")
    d.rectangle((0, 0, size[0], size[1]), fill=(*colors[0], 18))
    return Image.alpha_composite(bg.convert("RGBA"), tint).convert("RGB")


def make_background(size, colors, dark=False):
    w, h = size
    base = Image.new("RGB", size, (6, 18, 34) if dark else (244, 245, 238))
    arr = np.zeros((h, w, 3), dtype=np.uint8)
    c1 = np.array(colors[0], dtype=np.float32)
    c2 = np.array(colors[2], dtype=np.float32)
    c3 = np.array((8, 18, 32) if dark else (244, 245, 238), dtype=np.float32)
    for y in range(h):
        for x in range(w):
            t = (x / max(w - 1, 1)) * 0.65 + (y / max(h - 1, 1)) * 0.35
            col = c1 * (1 - t) + c2 * t
            col = col * (0.32 if dark else 0.18) + c3 * (0.68 if dark else 0.82)
            arr[y, x] = np.clip(col, 0, 255)
    img = Image.fromarray(arr, "RGB")
    d = ImageDraw.Draw(img, "RGBA")
    for i in range(14):
        x = int((i * 173) % w)
        y = int((i * 269) % h)
        d.ellipse((x - 160, y - 90, x + 240, y + 150), fill=(*colors[i % len(colors)], 22 if dark else 14))
    img = img.filter(ImageFilter.GaussianBlur(4 if dark else 6))
    return Image.blend(base, img, 0.85)


def find_images(target):
    img_dir = ROOT / "work" / "company_analysis" / target["folder"] / "images"
    files = {p.name: p for p in img_dir.glob("*.png")}
    thesis = next((p for n, p in files.items() if "investment-thesis" in n), None)
    upstream = next((p for n, p in files.items() if "upstream" in n), None)
    segment = next((p for n, p in files.items() if "segment" in n), None)
    history = next((p for n, p in files.items() if "performance" in n or "financial-history" in n), None)
    bridge = next((p for n, p in files.items() if "midterm" in n), None)
    return {"thesis": thesis, "upstream": upstream, "segment": segment, "history": history, "bridge": bridge}


class Renderer:
    def __init__(self, target, mode):
        self.t = target
        self.mode = mode
        self.video_dir = ROOT / "work" / "company_analysis" / target["folder"] / "video"
        self.video_dir.mkdir(parents=True, exist_ok=True)
        self.images = find_images(target)
        self.w, self.h = (1080, 1920) if mode == "shorts" else (1280, 720)
        self.fps = 30
        self.ai_bg_path = self.video_dir / "ai-background-20260520.png"
        if self.ai_bg_path.exists():
            self.bg_dark = make_ai_background(self.ai_bg_path, (self.w, self.h), target["colors"], dark=True)
            self.bg_light = make_ai_background(self.ai_bg_path, (self.w, self.h), target["colors"], dark=False)
        else:
            self.bg_dark = make_background((self.w, self.h), target["colors"], dark=True)
            self.bg_light = make_background((self.w, self.h), target["colors"], dark=False)
        prefix = f"{target['slug']}-{mode}"
        self.out = self.video_dir / f"{prefix}-unlisted-upload.mp4"
        self.silent = self.video_dir / f"_{prefix}-silent.mp4"
        self.audio = self.video_dir / f"_{prefix}-narration.mp3"
        self.seglist = self.video_dir / f"_{prefix}-segments.txt"
        self.thumb = self.video_dir / f"{prefix}-thumbnail.png"
        self.narration_txt = self.video_dir / f"_{prefix}-narration.txt"
        self.F_TITLE = font(82 if mode == "shorts" else 54, True)
        self.F_BIG = font(68 if mode == "shorts" else 42, True)
        self.F_MID = font(46 if mode == "shorts" else 30, True)
        self.F_BODY = font(36 if mode == "shorts" else 22, False)
        self.F_SMALL = font(28 if mode == "shorts" else 17, False)

    def base(self, dark=False):
        img = (self.bg_dark if dark else self.bg_light).copy()
        d = ImageDraw.Draw(img)
        accent = self.t["colors"][1]
        if self.mode == "shorts":
            d.rectangle((0, 0, self.w, 26), fill=accent)
            d.rectangle((0, self.h - 26, self.w, self.h), fill=accent)
            if dark:
                d.line((70, 162, self.w - 70, 162), fill=accent, width=5)
                d.line((70, self.h - 130, self.w - 70, self.h - 130), fill=accent, width=5)
        else:
            d.rectangle((0, 0, self.w, 18), fill=accent)
            if not dark:
                for y in range(118, self.h - 80, 72):
                    d.line((64, y, self.w - 64, y), fill=(229, 231, 224), width=1)
        return img

    def badge(self, d):
        if self.mode == "shorts":
            box = (self.w - 305, 90, self.w - 125, 148)
            rounded(d, box, 14, (255, 248, 226), self.t["colors"][1], 2)
            text_center_fit(d, (box[0] + 12, box[1], box[2] - 12, box[3]), "企業分析", font(28, False), (112, 83, 24), 1, 2)
        else:
            box = (self.w - 198, 34, self.w - 62, 76)
            rounded(d, box, 8, (255, 248, 226), self.t["colors"][1], 2)
            text_center_fit(d, (box[0] + 10, box[1], box[2] - 10, box[3]), "企業分析", font(20, True), (112, 83, 24), 1, 1)

    def footer(self, d, scene, dark=False):
        color = (235, 239, 238) if dark else (72, 80, 86)
        if self.mode == "shorts":
            footer_color = (240, 240, 232) if dark else (74, 82, 88)
            scene_color = (181, 190, 196) if dark else (125, 132, 136)
            d.text((70, self.h - 78), "保存して後で見返す", font=self.F_SMALL, fill=footer_color)
            d.text((self.w - 154, self.h - 78), f"Scene {scene}", font=self.F_SMALL, fill=scene_color)
        else:
            d.text((64, self.h - 42), "FIC投資研究所 / 企業を構造で読む", font=self.F_SMALL, fill=color)
            d.text((self.w - 112, self.h - 42), f"Scene {scene}", font=self.F_SMALL, fill=color)

    def scene_hook(self, scene=1):
        img = self.base(True)
        d = ImageDraw.Draw(img)
        self.badge(d)
        if self.mode == "shorts":
            d.text((70, 305), f"{self.t['company']}で", font=self.F_BIG, fill=(255, 255, 255))
            d.text((70, 420), "何を買う？", font=self.F_TITLE, fill=self.t["colors"][1])
            text_left_fit(d, (70, 555), self.t.get("hook_sub", f"{self.t['company']}を表面だけで見ると"), self.F_BODY, (235, 239, 238), 760, 2, 12)
            text_left_fit(d, (70, 620), self.t.get("hook_warning", "投資仮説を読み違える"), self.F_BODY, (235, 239, 238), 760, 2, 12)
            rounded(d, (88, 830, self.w - 88, 1025), 22, (255, 255, 250), self.t["colors"][1], 3)
            text_center_fit(d, (126, 850, self.w - 126, 1005), self.t.get("not_only", self.t["theme"]), self.F_MID, (20, 34, 49), 2, 10)
            rounded(d, (88, 1185, self.w - 88, 1335), 20, (255, 248, 226), self.t["colors"][1], 3)
            text_center_fit(d, (126, 1205, self.w - 126, 1315), self.t.get("short_takeaway", self.t["theme"]), self.F_BODY, (91, 70, 29), 2, 8)
            self.footer(d, scene, True)
        else:
            d.text((70, 170), "今回の論点", font=self.F_BIG, fill=(255, 255, 255))
            text_left_fit(d, (70, 245), self.t["hook"], self.F_TITLE, self.t["colors"][1], 600, 4, 8)
            rounded(d, (705, 215, 1165, 500), 16, (255, 255, 250), self.t["colors"][1], 3)
            text_center_fit(d, (740, 240, 1130, 405), self.t["theme"], self.F_MID, (16, 32, 48), 4, 8)
            text_center_fit(d, (748, 416, 1122, 472), self.t["one_liner"], self.F_BODY, (74, 82, 88), 2, 4)
            self.footer(d, scene, True)
        return img

    def scene_thesis_cards(self, scene=2):
        img = self.base(False)
        d = ImageDraw.Draw(img)
        self.badge(d)
        if self.mode == "shorts":
            text_center(d, (80, 205, self.w - 80, 380), "投資仮説は\n3つに分ける", self.F_BIG, (18, 34, 50), 8)
            y = 510
            for i, item in enumerate(self.t["drivers"]):
                rounded(d, (94, y, self.w - 94, y + 210), 22, (255, 255, 255), self.t["colors"][i % 3], 4)
                text_left_fit(d, (140, y + 38), item, self.F_MID, (18, 34, 50), self.w - 280, 1, 8)
                text_left_fit(d, (140, y + 108), self.explain_driver(item), self.F_BODY, (74, 82, 88), self.w - 280, 2, 8)
                y += 280
            rounded(d, (140, 1390, self.w - 140, 1500), 18, (7, 31, 49), None, 1)
            text_center_fit(d, (165, 1396, self.w - 165, 1494), self.t.get("short_takeaway", "構造変化を見る"), self.F_BODY, (255, 255, 255), 2, 6)
            self.footer(d, scene)
        else:
            d.text((64, 54), f"{c if (c := self.t['company']) else ''}で買う3つの変化", font=self.F_BIG, fill=(18, 34, 50))
            x = 78
            for i, item in enumerate(self.t["drivers"]):
                rounded(d, (x, 185, x + 350, 508), 16, (255, 255, 255), self.t["colors"][i % 3], 4)
                rounded(d, (x + 24, 214, x + 76, 266), 10, self.t["colors"][i % 3], None, 1)
                text_center_fit(d, (x + 24, 214, x + 76, 266), str(i + 1), font(28, True), (255, 255, 255), 1, 1)
                text_left_block_fit(d, (x + 96, 202, x + 322, 286), self.driver_title(item), self.F_MID, self.t["colors"][i % 3], 2, 5)
                note = self.t.get("driver_notes", [self.explain_driver(v) for v in self.t["drivers"]])[i]
                text_left_fit(d, (x + 34, 324), note, self.F_BODY, (74, 82, 88), 282, 4, 6)
                x += 410
            rounded(d, (155, 548, 1125, 636), 12, (7, 31, 49), None, 1)
            text_center_fit(d, (180, 552, 1100, 632), self.t["one_liner"], self.F_BODY, (255, 255, 255), 2, 4)
            self.footer(d, scene)
        return img

    def driver_title(self, item):
        mapping = {
            "生活関連の黒字化": "生活関連の\n黒字化",
            "木材・バイオマス": "木材・\nバイオマス",
            "ROE改善": "ROE改善",
            "水道インフラ更新": "水道インフラ\n更新",
            "機械システムの採算": "機械システム\nの採算",
            "ROE 8%への階段": "ROE 8%への\n階段",
            "4地域分散": "4地域分散",
            "価格転嫁力": "価格転嫁力",
            "ROIC経営": "ROIC経営",
            "HRテック需要": "HRテック\n需要",
            "Indeed単価改善": "Indeed\n単価改善",
            "株主還元と投資": "株主還元と\n投資",
            "国内金利": "国内金利",
            "貸出・預金利ざや": "貸出・預金\n利ざや",
            "与信費用と還元": "与信費用と\n還元",
            "インフラの継続収益": "インフラの\n継続収益",
            "金融・暗号資産市況": "金融・暗号資産\n市況",
            "広告・メディア": "広告・メディア",
            "処方箋枚数": "処方箋枚数",
            "さくら薬局PMI": "さくら薬局\nPMI",
            "リテール利益率": "リテール\n利益率",
            "荒利益率": "荒利益率",
            "海外出店": "海外出店",
            "島忠改革": "島忠改革",
            "AI/DC向けSSD": "AI/DC向け\nSSD",
            "NAND需給・ASP": "NAND需給・\nASP",
            "BiCS/CBAコスト低減": "BiCS/CBA\nコスト低減",
        }
        return mapping.get(item, item)

    def explain_driver(self, item):
        mapping = {
            "生活関連の黒字化": "紙から家庭紙・包装へ利益を移す",
            "木材・バイオマス": "森林資源を収益化できるか",
            "中計2030のROE改善": "低ROEからの再評価余地",
            "ROE改善": "低ROEからの再評価余地",
            "水道インフラ更新": "官需で需要の底を作る",
            "機械システムの採算": "民需の波を利益率で吸収",
            "ROE 8%への階段": "既達後の次の目標",
            "4地域分散": "日米欧アジアでリスクを分ける",
            "価格転嫁力": "鋼材高を利益率で吸収",
            "ROIC経営": "資本効率で評価を高める",
            "HRテック需要": "求人市場の回復を取り込む",
            "Indeed単価改善": "送客価値を収益に変える",
            "株主還元と投資": "成長投資と還元の両立",
            "国内金利": "利ざや改善の追い風",
            "貸出・預金利ざや": "本業利益を押し上げる",
            "与信費用と還元": "利益の質を確認する",
            "インフラの継続収益": "ドメイン・サーバーの土台",
            "金融・暗号資産市況": "利益の振れ幅を作る",
            "広告・メディア": "成長余地と競争を見る",
            "処方箋枚数": "調剤薬局の売上の土台",
            "さくら薬局PMI": "買収を利益に変える実行力",
            "リテール利益率": "コスメ・雑貨で利益を補う",
            "荒利益率": "原価低減の成果を見る",
            "海外出店": "長期成長の本命",
            "島忠改革": "低収益領域の改善余地",
            "AI/DC向けSSD": "高容量需要を取り込む",
            "NAND需給・ASP": "利益を大きく動かす市況",
            "BiCS/CBAコスト低減": "下落局面への耐性",
        }
        return mapping.get(item, "業績へのつながりを見る")

    def scene_image(self, key, title, subtitle, scene=3):
        path = self.images.get(key)
        if path and path.exists():
            if self.mode == "shorts":
                img = self.base(False)
                d = ImageDraw.Draw(img)
                self.badge(d)
                text_center(d, (80, 180, self.w - 80, 315), title, self.F_BIG, (18, 34, 50), 9)
                fit = fit_image(path, (940, 940))
                img.paste(fit, (70, 390))
                rounded(d, (100, 1395, self.w - 100, 1505), 18, (7, 31, 49), None, 1)
                text_center(d, (120, 1395, self.w - 120, 1505), subtitle, self.F_BODY, (255, 255, 255), 14)
                self.footer(d, scene)
                return img
            img = self.base(False)
            d = ImageDraw.Draw(img, "RGBA")
            d.rounded_rectangle((50, 54, self.w - 50, self.h - 54), radius=18, fill=(255, 255, 255, 226), outline=(*self.t["colors"][1], 160), width=3)
            d.text((74, 76), title, font=self.F_BIG, fill=(18, 34, 50))
            d.text((74, 126), subtitle, font=self.F_BODY, fill=(72, 80, 86))
            fit = fit_image(path, (1080, 500), bg=(255, 255, 255))
            img.paste(fit, (100, 165))
            self.footer(ImageDraw.Draw(img), scene)
            return img
        return self.scene_thesis_cards(scene)

    def scene_metric_callout(self, scene=4):
        metric = self.t["metric_slide"]
        img = self.base(True)
        d = ImageDraw.Draw(img, "RGBA")
        self.badge(d)
        if self.mode == "shorts":
            text_left_fit(d, (70, 250), metric["title"], self.F_MID, (255, 255, 255), 760, 2, 8)
            text_left_fit(d, (70, 345), metric["headline"], self.F_TITLE, self.t["colors"][1], 760, 3, 10)
            rounded(d, (90, 720, self.w - 90, 1025), 28, (255, 255, 250), self.t["colors"][1], 5)
            text_center_fit(d, (130, 760, self.w - 130, 845), metric["from"], font(58, True), (18, 34, 50), 1, 4)
            text_center_fit(d, (130, 865, self.w - 130, 920), "↓", font(46, True), (120, 70, 60), 1, 2)
            text_center_fit(d, (130, 940, self.w - 130, 1002), metric["to"], font(58, True), (120, 70, 60), 1, 4)
            rounded(d, (95, 1200, self.w - 95, 1380), 18, (255, 248, 226), self.t["colors"][1], 3)
            text_center_fit(d, (130, 1205, self.w - 130, 1375), metric["note"], self.F_BODY, (90, 66, 24), 4, 5)
            self.footer(d, scene, True)
            return img
        d.line((54, 52, 1190, 52), fill=self.t["colors"][1], width=4)
        text_left_fit(d, (70, 150), metric["title"], self.F_BIG, (255, 255, 255), 520, 2, 8)
        text_left_fit(d, (70, 225), metric["headline"], self.F_TITLE, self.t["colors"][1], 560, 2, 10)
        rounded(d, (710, 142, 1138, 402), 16, (255, 255, 250), self.t["colors"][1], 3)
        text_center_fit(d, (744, 172, 1104, 238), metric["from"], font(42, True), (18, 34, 50), 1, 4)
        text_center_fit(d, (744, 250, 1104, 305), "↓", font(34, True), (120, 70, 60), 1, 2)
        text_center_fit(d, (744, 322, 1104, 384), metric["to"], font(42, True), (120, 70, 60), 1, 4)
        rounded(d, (70, 500, 1135, 590), 12, (255, 248, 226), self.t["colors"][1], 3)
        text_center_fit(d, (100, 505, 1105, 585), metric["note"], self.F_MID, (90, 66, 24), 2, 5)
        self.footer(d, scene, True)
        return img

    def scene_checkpoints(self, scene=5):
        img = self.base(False)
        d = ImageDraw.Draw(img)
        self.badge(d)
        title = "次の決算で追う3つの確認点"
        if self.mode == "shorts":
            text_center(d, (80, 220, self.w - 80, 390), title, self.F_TITLE, (18, 34, 50), 7)
            y = 540
            for i, item in enumerate(self.t["checks"]):
                rounded(d, (120, y, self.w - 120, y + 160), 20, (255, 255, 255), (205, 211, 218), 3)
                rounded(d, (152, y + 48, 218, y + 114), 999, self.t["colors"][i % 3], None, 1)
                d.text((250, y + 40), item, font=self.F_MID, fill=(18, 34, 50))
                y += 215
            rounded(d, (120, 1305, self.w - 120, 1465), 20, (255, 248, 226), self.t["colors"][1], 3)
            text_center(d, (150, 1305, self.w - 150, 1465), "決算・月次・中計更新で、仮説が続くかを見る", self.F_BODY, (90, 66, 24), 13)
            self.footer(d, scene)
        else:
            d.text((64, 54), title, font=self.F_BIG, fill=(18, 34, 50))
            y = 180
            notes = self.t.get("check_notes", ["前進しているかを確認", "利益に出ているかを確認", "評価につながるかを確認"])
            for i, item in enumerate(self.t["checks"]):
                rounded(d, (120, y, 1160, y + 112), 14, (255, 255, 255), (205, 211, 218), 2)
                rounded(d, (155, y + 28, 207, y + 80), 999, self.t["colors"][i % 3], None, 1)
                text_center_fit(d, (155, y + 28, 207, y + 80), str(i + 1), font(27, True), (255, 255, 255), 1, 1)
                d.text((245, y + 24), item, font=self.F_MID, fill=(18, 34, 50))
                text_left_fit(d, (245, y + 65), notes[i], self.F_BODY, (74, 82, 88), 850, 2, 4)
                y += 130
            rounded(d, (190, 565, 1090, 625), 12, (7, 31, 49), None, 1)
            text_center_fit(d, (210, 565, 1070, 625), f"リスク: {self.t['risk']}", self.F_BODY, (255, 255, 255), 2, 3)
            self.footer(d, scene)
        return img

    def scene_cta(self, scene=6):
        img = self.base(False if self.mode == "shorts" else True)
        d = ImageDraw.Draw(img)
        self.badge(d)
        if self.mode == "shorts":
            takeaway = self.t.get("short_takeaway", self.t["theme"]).replace("を見る", "")
            title = f"{self.t['company']}は\n{takeaway}"
            long_theme = self.t.get("final_long_theme", self.t["drivers"][1] if len(self.t["drivers"]) > 1 else "構造変化")
            short_risk = self.t.get("final_short_risk", self.t["checks"][0] if self.t.get("checks") else "次の決算")
            text_center_fit(d, (105, 285, self.w - 105, 530), title, self.F_TITLE, (18, 34, 50), 3, 8)
            rounded(d, (135, 740, self.w - 135, 1038), 22, (255, 255, 250), (205, 211, 218), 2)
            text_center_fit(
                d,
                (180, 785, self.w - 180, 960),
                f"長期テーマは{long_theme}\n短期リスクは{short_risk}",
                self.F_MID,
                self.t["colors"][0],
                2,
                8,
            )
            text_center_fit(d, (150, 1150, self.w - 150, 1225), "詳しくは記事・長尺動画で", self.F_BODY, (74, 82, 88), 1, 4)
            self.footer(d, scene)
        else:
            d.text((76, 170), "まとめ", font=self.F_BIG, fill=(255, 255, 255))
            text_left_fit(d, (76, 245), self.t["theme"], self.F_TITLE, self.t["colors"][1], 1085, 2, 10)
            rounded(d, (76, 455, 1160, 545), 12, (255, 255, 250), self.t["colors"][1], 3)
            text_center(d, (110, 455, 1126, 545), f"記事で、根拠と先行指標を確認してください", self.F_MID, (18, 34, 50), 25)
            self.footer(d, scene, True)
        return img

    def scene_text_cards(self, title, cards, bottom, scene=4):
        img = self.base(False)
        d = ImageDraw.Draw(img)
        self.badge(d)
        d.text((64, 54), title, font=self.F_BIG, fill=(18, 34, 50))
        x = 86
        for i, (head, body) in enumerate(cards):
            rounded(d, (x, 190, x + 330, 492), 16, (255, 255, 255), self.t["colors"][i % 3], 4)
            rounded(d, (x + 22, 214, x + 70, 262), 8, self.t["colors"][i % 3], None, 1)
            text_center_fit(d, (x + 22, 214, x + 70, 262), str(i + 1), font(25, True), (255, 255, 255), 1, 1)
            text_left_block_fit(d, (x + 88, 202, x + 304, 286), head, self.F_MID, self.t["colors"][i % 3], 2, 5)
            text_left_fit(d, (x + 34, 322), body, self.F_BODY, (74, 82, 88), 272, 5, 6)
            x += 395
        rounded(d, (190, 560, 1090, 628), 12, (7, 31, 49), None, 1)
        text_center_fit(d, (214, 560, 1066, 628), bottom, self.F_BODY, (255, 255, 255), 2, 4)
        self.footer(d, scene)
        return img

    def scenes_and_narrations(self):
        c = self.t["company"]
        full = self.t["full_name"]
        if self.mode == "shorts":
            scenes = [
                (self.scene_hook, f"{full}を買うなら、何を買う投資なのか。ここを最初に整理します。"),
                (self.scene_thesis_cards, f"結論は、{self.t['theme']}です。見る変化は、{self.t['drivers'][0]}、{self.t['drivers'][1]}、{self.t['drivers'][2]}の3つです。"),
                (self.scene_metric_callout, f"ただし投資仮説は、ストーリーだけではなく数字で確認します。山場は、{self.t['metric_slide']['title']}。{self.t['metric_slide']['from']}から{self.t['metric_slide']['to']}へ進めるかです。"),
                (self.scene_checkpoints, f"次の決算で追うのは、{self.t['checks'][0]}、{self.t['checks'][1]}、{self.t['checks'][2]}。そろえば仮説は強く、崩れれば見直しです。"),
                (self.scene_cta, f"要するに、{c}は、{self.t['one_liner']} 詳しい根拠は長尺動画と記事で確認します。"),
            ]
        else:
            scenes = [
                (self.scene_hook, f"{full}を、見た目の業種だけで判断すると、投資仮説を読み違えます。この動画では、{c}で何を買うのかを、初心者にも分かるように整理します。"),
                (lambda s=2: self.scene_image("thesis", "投資仮説マップ", f"中心テーマ: {self.t['theme']}", s), f"まず、この投資仮説マップを見てください。左から、業界や需要の変化、会社のポジション、業績への変換、投資判断の順番です。{c}は、表面的な業種名だけで見るのではなく、{self.t['theme']}として見る会社です。"),
                (self.scene_thesis_cards, f"結論から言うと、{c}で買っている変化は3つです。1つ目は、{self.t['drivers'][0]}。{self.t['driver_notes'][0]} 2つ目は、{self.t['drivers'][1]}。{self.t['driver_notes'][1]} 3つ目は、{self.t['drivers'][2]}。{self.t['driver_notes'][2]}"),
                (lambda s=4: self.scene_text_cards("利益に変わる道筋", self.t["profit_cards"], "見た目の売上ではなく、利益を動かす要因で見る", s), f"次に、利益に変わる道筋を見ます。{self.t['profit_cards'][0][0]}は、{self.t['profit_cards'][0][1]} {self.t['profit_cards'][1][0]}は、{self.t['profit_cards'][1][1]} {self.t['profit_cards'][2][0]}は、{self.t['profit_cards'][2][1]}"),
                (lambda s=5: self.scene_image("upstream", "業績ドライバー", f"{self.t['checks'][0]} / {self.t['checks'][1]} / {self.t['checks'][2]}", s), f"次に、この業績ドライバーの図を見ます。{c}では、{self.t['checks'][0]}、{self.t['checks'][1]}、{self.t['checks'][2]}が、ストーリーを数字で裏付ける確認点になります。"),
                (self.scene_metric_callout, f"数字で見る山場は、{self.t['metric_slide']['title']}です。{self.t['metric_slide']['headline']}。画面の数字のように、{self.t['metric_slide']['from']}から{self.t['metric_slide']['to']}へ進めるかが、投資仮説の分かれ目です。主因は、{self.t['metric_slide']['note']}です。"),
                (self.scene_checkpoints, f"最後に、買った後に次の決算や中計更新で追う確認点です。見るのは、{self.t['checks'][0]}、{self.t['checks'][1]}、{self.t['checks'][2]}。ここが崩れると、仮説の見直しが必要です。反証は、{self.t['risk']}です。"),
                (self.scene_cta, f"まとめると、{c}は、{self.t['one_liner']} 見るべきポイントは、{self.t['checks'][0]}、{self.t['checks'][1]}、{self.t['checks'][2]}です。詳しい数字、前提条件、リスクは記事本文で確認してください。"),
            ]
        return scenes

    def normalize_tts(self, text):
        out = text
        placeholder = "__FIC_FULL_COMPANY_NAME__"
        out = out.replace(self.t["full_name"], placeholder)
        out = out.replace(self.t["company"], self.t["full_name"])
        out = out.replace(placeholder, self.t["full_name"])
        for src, dst in TTS_REPLACEMENTS.items():
            out = out.replace(src, dst)
        return out

    async def make_audio(self, narrations):
        self.narration_txt.write_text("\n".join(self.normalize_tts(n) for n in narrations), encoding="utf-8")
        rate = "+15%" if self.mode == "shorts" else "+10%"
        paths = []
        for i, narration in enumerate(narrations, start=1):
            p = self.video_dir / f"_{self.t['slug']}-{self.mode}-narration-{i:02d}.mp3"
            communicate = edge_tts.Communicate(self.normalize_tts(narration), voice="ja-JP-NanamiNeural", rate=rate)
            await communicate.save(str(p))
            paths.append(p)
        self.seglist.write_text("\n".join(f"file '{p.as_posix()}'" for p in paths), encoding="utf-8")
        ffmpeg = imageio_ffmpeg.get_ffmpeg_exe()
        subprocess.run([ffmpeg, "-y", "-f", "concat", "-safe", "0", "-i", str(self.seglist), "-c:a", "libmp3lame", "-q:a", "4", str(self.audio)], check=True)
        return [float(MP3(str(p)).info.length) for p in paths]

    def render_video(self, scene_fns, durations):
        total = sum(max(d, 1.0) for d in durations)
        starts, acc = [], 0.0
        for fn, dur in zip(scene_fns, durations):
            dur = max(float(dur), 1.0)
            starts.append((acc, acc + dur, fn))
            acc += dur
        writer = imageio.get_writer(
            str(self.silent),
            fps=self.fps,
            codec="libx264",
            quality=8,
            macro_block_size=1,
            ffmpeg_params=["-pix_fmt", "yuv420p", "-movflags", "+faststart"],
        )
        frame_count = int(math.ceil(total * self.fps))
        thumb_saved = False
        cache = {}
        for i in range(frame_count):
            t = i / self.fps
            idx = 0
            for j, (st, en, _fn) in enumerate(starts):
                if st <= t < en or j == len(starts) - 1:
                    idx = j
                    break
            if idx not in cache:
                cache[idx] = starts[idx][2](idx + 1)
            frame = cache[idx]
            if not thumb_saved and t >= 1.0:
                frame.save(self.thumb)
                thumb_saved = True
            writer.append_data(np.asarray(frame))
        writer.close()

    def mux(self):
        ffmpeg = imageio_ffmpeg.get_ffmpeg_exe()
        subprocess.run([ffmpeg, "-y", "-i", str(self.silent), "-i", str(self.audio), "-c:v", "copy", "-c:a", "aac", "-b:a", "192k", "-shortest", str(self.out)], check=True)

    def write_docs(self, long_url="", shorts_url=""):
        prompt = self.video_dir / "video_creation_prompt.md"
        record = self.video_dir / "production_record.md"
        long_script = self.video_dir / "long_video_script.md"
        shorts_script = self.video_dir / "shorts_script.md"
        materials = self.video_dir / "screen_text_and_materials.md"
        prompt.write_text(f"""# {self.t['company']}（{self.t['code']}）動画作成プロンプト

対象記事: {self.t['article_url']}
対象企業: {self.t['full_name']}（{self.t['code']}）

## 動画の軸

{self.t['theme']}

初心者向けには、まず「何を買う投資なのか」を明確にし、売上規模と利益ドライバーを分けて説明する。

## 標準ルール

- 長尺は記事理解、因果マップ、先行指標、リスク確認に使う。
- Shortsは入口。主軸は「{self.t['company']}で何を買うのか」。
- ShortsにはAI生成図解を無理に入れない。スマホで一瞬で読めるカード、短い説明文、確認ポイントを優先する。
- AI生成図解は原則として長尺で使い、音声で見方を説明する。
- 音声は Edge TTS `ja-JP-NanamiNeural`。Shorts `rate=+15%`、長尺 `rate=+10%`。
- 尺はShorts 50〜58秒、長尺4分〜4分45秒を目安にし、初心者向け説明と図の読み方を削りすぎない。
- シーンごとにTTS音声を作り、各音声セグメントの尺に画面を合わせる。
- 記事AI図解を長尺に入れる場合は、音声で図の読み方と見る順番を説明する。
- 動画内最後の長い免責文は入れない。
- YouTubeアップロード後、古い不要版とローカル動画・音声中間素材を削除する。
- 記事へ貼る場合は `fic-lite-youtube-embed` の軽量YouTube埋め込みを使う。
""", encoding="utf-8")
        long_scenes = self.scenes_and_narrations() if self.mode == "long" else Renderer(self.t, "long").scenes_and_narrations()
        shorts_scenes = self.scenes_and_narrations() if self.mode == "shorts" else Renderer(self.t, "shorts").scenes_and_narrations()
        long_script.write_text("# 長尺動画台本\n\n" + "\n\n".join(f"## Scene {i}\n{n}" for i, (_, n) in enumerate(long_scenes, 1)), encoding="utf-8")
        shorts_script.write_text("# Shorts台本\n\n" + "\n\n".join(f"## Scene {i}\n{n}" for i, (_, n) in enumerate(shorts_scenes, 1)), encoding="utf-8")
        material_lines = ["# 画面テキスト・素材リスト", "", f"- 記事URL: {self.t['article_url']}", f"- 投資仮説: {self.t['theme']}"]
        for k, p in self.images.items():
            if p:
                material_lines.append(f"- {k}: `{p.relative_to(ROOT)}`")
        materials.write_text("\n".join(material_lines) + "\n", encoding="utf-8")
        if not record.exists():
            record.write_text(f"""# {self.t['company']}（{self.t['code']}）動画作業記録

作成日: 2026-05-19
対象記事: {self.t['article_url']}
対象企業: {self.t['full_name']}（{self.t['code']}）

## 制作方針

- 動画の軸: {self.t['theme']}
- Shorts主軸: {self.t['company']}で何を買うのか。
- 長尺では投資仮説マップ、収益構造、業績ドライバー、中期目標への道筋を順番に説明。

## 作成ファイル

- `video_creation_prompt.md`
- `long_video_script.md`
- `shorts_script.md`
- `screen_text_and_materials.md`

## YouTubeアップロード

- 状態: 未アップロード
""", encoding="utf-8")

    def cleanup_intermediates(self):
        patterns = [
            f"_{self.t['slug']}-{self.mode}-narration-*.mp3",
            f"_{self.t['slug']}-{self.mode}-silent.mp4",
            f"_{self.t['slug']}-{self.mode}-narration.mp3",
            f"_{self.t['slug']}-{self.mode}-segments.txt",
        ]
        for pat in patterns:
            for p in self.video_dir.glob(pat):
                p.unlink(missing_ok=True)

    def run(self):
        scenes = self.scenes_and_narrations()
        scene_fns = [fn for fn, _ in scenes]
        narrations = [n for _, n in scenes]
        durations = asyncio.run(self.make_audio(narrations))
        self.render_video(scene_fns, durations)
        self.mux()
        self.write_docs()
        print(json.dumps({
            "company": self.t["company"],
            "mode": self.mode,
            "video": str(self.out),
            "thumbnail": str(self.thumb),
            "duration": round(sum(durations), 2),
        }, ensure_ascii=False))


def create_manifest(targets):
    manifest = []
    for t in targets:
        vdir = ROOT / "work" / "company_analysis" / t["folder"] / "video"
        for mode, label in [("shorts", "Shorts版"), ("long", "長尺版")]:
            video = vdir / f"{t['slug']}-{mode}-unlisted-upload.mp4"
            title = (
                f"{t['company']}で何を買う？{t['theme']} #Shorts"
                if mode == "shorts"
                else f"{t['company']}（{t['code']}）で何を買う？{t['theme']}企業分析"
            )
            description = (
                f"{t['full_name']}（{t['code']}）を、初心者にも分かるように「何を買う投資なのか」から整理します。\n\n"
                f"詳しい分析記事はこちら:\n{t['article_url']}?utm_source=youtube&utm_medium={'shorts' if mode == 'shorts' else 'video'}_description&utm_campaign={t['slug']}_company_video\n\n"
                f"この動画の軸:\n{t['theme']}\n\n"
                f"確認ポイント:\n・{t['checks'][0]}\n・{t['checks'][1]}\n・{t['checks'][2]}\n\n"
                "FIC投資研究所:\nhttps://fic-investment.biz/\n\n"
                "※本動画は投資判断材料の整理を目的としており、特定銘柄の売買を推奨するものではありません。\n\n"
                f"#{t['company']} #{t['code']} #日本株 #企業分析 #投資分析"
            )
            fixed_comment = (
                f"詳しい分析記事はこちら:\n{t['article_url']}?utm_source=youtube&utm_medium={'shorts' if mode == 'shorts' else 'video'}_comment&utm_campaign={t['slug']}_company_video\n\n"
                f"{t['company']}は、{t['one_liner']}"
            )
            manifest.append({
                "company": f"{t['company']} {label}",
                "stock_code": f"{t['code']}_{mode.upper()}_20260519",
                "video_path": str(video),
                "title": title[:100],
                "description": description,
                "fixed_comment": fixed_comment,
                "tags": ["日本株", "企業分析", t["full_name"], t["company"], t["code"], "FIC投資研究所"],
                "category_id": "27",
                "privacy_status": "unlisted",
            })
    out = ROOT / "assets" / "videos" / "youtube_upload_manifest_company_batch_20260519.json"
    out.write_text(json.dumps(manifest, ensure_ascii=False, indent=2), encoding="utf-8")
    print(out)


def selected_targets(names):
    if not names:
        return TARGETS
    keys = {n.lower() for n in names}
    return [t for t in TARGETS if t["folder"].lower() in keys or t["code"].lower() in keys or t["company"].lower() in keys]


def main():
    parser = argparse.ArgumentParser()
    parser.add_argument("--target", action="append", default=[])
    parser.add_argument("--mode", choices=["shorts", "long", "both"], default="both")
    parser.add_argument("--manifest-only", action="store_true")
    parser.add_argument("--cleanup", action="store_true")
    args = parser.parse_args()
    targets = selected_targets(args.target)
    if args.manifest_only:
        create_manifest(targets)
        return
    for t in targets:
        modes = ["shorts", "long"] if args.mode == "both" else [args.mode]
        for mode in modes:
            r = Renderer(t, mode)
            r.run()
            if args.cleanup:
                r.cleanup_intermediates()
    create_manifest(targets)


if __name__ == "__main__":
    main()
