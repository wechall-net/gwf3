#!/usr/bin/env python3
"""Format challenge.yaml files."""

import argparse
import sys
from pathlib import Path

import yaml.scanner
import yaml.parser


class ChallengeDumper(yaml.SafeDumper):
    pass


def represent_compact_list(dumper, value):
    node = yaml.SafeDumper.represent_list(dumper, value)
    if all(isinstance(item, (str, int, float, bool)) or item is None for item in value):
        node.flow_style = True
    return node


ChallengeDumper.add_representer(list, represent_compact_list)


def represent_multiline_string(dumper, value):
    value = value.lstrip("\n")
    style = "|" if "\n" in value else None
    return dumper.represent_scalar("tag:yaml.org,2002:str", value, style=style)


ChallengeDumper.add_representer(str, represent_multiline_string)


def main():
    parser = argparse.ArgumentParser()
    parser.add_argument("root", nargs="?", default="www/challenge")
    parser.add_argument("--apply", action="store_true")
    parser.add_argument("--check", action="store_true", help="fail when files are not canonically formatted")
    parser.add_argument("--file", action="append", dest="files", help="check or format only this file")
    args = parser.parse_args()

    code = 0
    files = [Path(file) for file in args.files] if args.files else sorted(Path(args.root).rglob("challenge.yaml"))
    for path in files:
        try:
            original = path.read_text(encoding="utf-8")
            data = yaml.safe_load(original)
        except (yaml.scanner.ScannerError, yaml.parser.ParserError) as exc:
            print('ERROR', path, exc)
            code = 1
            continue

        formatted = yaml.dump(
            data,
            Dumper=ChallengeDumper,
            allow_unicode=True,
            default_flow_style=False,
            sort_keys=False,
            width=120,
        )
        if args.check and formatted != original:
            print('NOT FORMATTED', path)
            code = 1
        if args.apply:
            path.write_text(formatted, encoding="utf-8")
        else:
            if not args.check:
                print(path)
    if not args.apply and not args.check:
        print(f"Dry run: {len(files)} file(s). Re-run with --apply to format them.")
    return code


if __name__ == "__main__":
    sys.exit(main())
