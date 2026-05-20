import argparse
import re
from pathlib import Path

from PIL import Image, ImageDraw

from batch_company_video_generator import ROOT, TARGETS, font, make_ai_background, rounded, text_center, text_left


LOGO_PATH = ROOT / "assets" / "videos" / "fic-logo-header-white-h96.png"
CONTACT_SHEET = ROOT / "assets" / "videos" / "qa_all_thumbnails_ai_bg_20260520.jpg"


def paste_logo(img, logo_path=LOGO_PATH):
    d = ImageDraw.Draw(img, "RGBA")
    logo = Image.open(logo_path).convert("RGBA")
    logo.thumbnail((246, 46), Image.Resampling.LANCZOS)
    x, y = 42, 38
    pad_x, pad_y = 14, 10
    box = (x, y, x + logo.width + pad_x * 2, y + logo.height + pad_y * 2)
    rounded(d, box, 10, (255, 255, 255, 245), (211, 168, 46), 2)
    img.paste(logo, (x + pad_x, y + pad_y), logo)


def split_units(text):
    return re.findall(r"[A-Za-z0-9&/().+-]+|[^\sA-Za-z0-9&/().+-]", text)


def wrap_by_width(draw, text, fnt, max_width, max_lines=3):
    lines = []
    current = ""
    for unit in split_units(text):
        candidate = current + unit
        width = draw.textbbox((0, 0), candidate, font=fnt)[2]
        if current and width > max_width:
            lines.append(current)
            current = unit
            if len(lines) == max_lines - 1:
                break
        else:
            current = candidate
    rest = text[text.find(current) + len(current):] if current and current in text else ""
    if rest and len(lines) == max_lines - 1:
        current = current.rstrip("、。") + "..."
    if current:
        lines.append(current)
    return lines[:max_lines]


def draw_left_wrapped(draw, xy, text, fnt, fill, max_width, max_lines=3, gap=8):
    x, y = xy
    for line in wrap_by_width(draw, text, fnt, max_width, max_lines):
        draw.text((x, y), line, font=fnt, fill=fill)
        box = draw.textbbox((0, 0), line, font=fnt)
        y += (box[3] - box[1]) + gap


def compose_thumbnail(target, mode):
    video_dir = ROOT / "work" / "company_analysis" / target["folder"] / "video"
    bg_path = video_dir / "ai-background-20260520.png"
    out = video_dir / f"{target['slug']}-{mode}-thumbnail.png"
    size = (1280, 720)
    img = make_ai_background(bg_path, size, target["colors"], dark=True)
    d = ImageDraw.Draw(img, "RGBA")
    accent = target["colors"][1]

    # Darken the copy area while leaving the AI background recognizable.
    d.rectangle((0, 0, 690, 720), fill=(0, 0, 0, 108))
    paste_logo(img)

    rounded(d, (982, 42, 1218, 86), 12, (255, 255, 255, 244), accent, 2)
    d.text((1040, 51), "企業分析", font=font(24, True), fill=(112, 83, 24))

    title_y = 150
    d.text((58, title_y), target["company"], font=font(66, True), fill=(255, 255, 255))
    d.text((58, title_y + 83), "何を買う？", font=font(70, True), fill=accent)
    draw_left_wrapped(d, (58, title_y + 188), target["theme"], font(43, True), (255, 255, 255), 650, 3, 8)

    chip_y = 502
    x = 58
    for item in target["checks"]:
        label = item.replace("中計2030の", "").replace("への距離", "")
        width = min(300, max(128, 28 * len(label) + 34))
        rounded(d, (x, chip_y, x + width, chip_y + 48), 9, (18, 39, 58, 232), accent, 2)
        text_center(d, (x + 10, chip_y, x + width - 10, chip_y + 48), label, font(26, True), (255, 255, 255), 10, 2)
        x += width + 16
        if x > 900:
            break

    rounded(d, (58, 574, 1098, 668), 8, (255, 255, 255, 244), accent, 2)
    text_center(d, (82, 580, 1074, 662), target["one_liner"], font(24, False), (18, 34, 50), 30, 4)
    d.text((58, 684), "FIC投資研究所  |  fic-investment.biz", font=font(26, False), fill=(245, 248, 248))
    out.parent.mkdir(parents=True, exist_ok=True)
    img.save(out, quality=95)
    return out


def selected_targets(names):
    if not names:
        return TARGETS
    keys = {n.lower() for n in names}
    return [t for t in TARGETS if t["folder"].lower() in keys or t["code"].lower() in keys or t["company"].lower() in keys]


def make_contact_sheet(paths):
    thumbs = [Image.open(p).convert("RGB").resize((320, 180), Image.Resampling.LANCZOS) for p in paths]
    cols = 3
    rows = (len(thumbs) + cols - 1) // cols
    sheet = Image.new("RGB", (cols * 320, rows * 180), (245, 245, 241))
    for i, thumb in enumerate(thumbs):
        sheet.paste(thumb, ((i % cols) * 320, (i // cols) * 180))
    sheet.save(CONTACT_SHEET, quality=92)
    return CONTACT_SHEET


def main():
    parser = argparse.ArgumentParser()
    parser.add_argument("--target", action="append", default=[])
    parser.add_argument("--mode", choices=["shorts", "long", "both"], default="both")
    args = parser.parse_args()
    targets = selected_targets(args.target)
    modes = ["shorts", "long"] if args.mode == "both" else [args.mode]
    paths = []
    for target in targets:
        for mode in modes:
            path = compose_thumbnail(target, mode)
            print(path)
            paths.append(path)
    if len(paths) > 1:
        print(make_contact_sheet(paths))


if __name__ == "__main__":
    main()
