import sys
import json
import os
import csv
import time
import traceback
from datetime import datetime
from unittest import result
from db import get_connection
import calendar


 

def main(argv=None):
    if argv is None:
        argv = sys.argv[1:]
    print("argv:", sys.argv)
    
    # Check if first argument is a JSON file
    if len(argv) == 1 and argv[0].endswith('.json'):
        json_file = argv[0]
        if os.path.exists(json_file):
            with open(json_file, 'r') as f:
                payload = json.load(f)
            periodfromdate = payload.get('periodfromdate')
            periodtodate = payload.get('periodtodate')
            companyId = int(payload.get('company_id') or payload.get('companyId') or 0)
            upshare = int(payload.get('upshare') or 0)
            upsel = int(payload.get('upallsel') or payload.get('upsel') or 0)
        else:
            print(f"Error: JSON file '{json_file}' not found")
            return
    elif len(argv) < 3:
        print("Usage: pfd1.py <from> <to> <companyId> [upshare] [upsel]")
        print("   or: pfd1.py <payload.json>")
        return
    else:
        periodfromdate = argv[0]
        periodtodate = argv[1]
        companyId = int(argv[2])
        upshare = int(argv[3]) if len(argv) > 3 else 0
        upsel = int(argv[4]) if len(argv) > 4 else 0
    
    fstart_time = time.time()
    print("Starting pfupdgen.py...",fstart_time)
    print(f"Parameters: from={periodfromdate}, to={periodtodate}, "    
          f"companyId={companyId}, upshare={upshare}, upsel={upsel}")
    print(f"Calling gen_monthpfupdatapy with: periodfromdate={periodfromdate}, "
          f"periodtodate={periodtodate}, companyId={companyId}, upshare={upshare}, upsel={upsel}")

    start_time = time.time()
    conn = get_connection()
    cursor = conn.cursor(dictionary=True)
    #result = gen_monthpfupdatapy(periodfromdate, periodtodate, companyId, upshare, upsel)
    end_time = time.time()
    print(f"Execution time: {end_time - start_time:.2f} seconds")

    print(json.dumps(result, default=str, indent=2))

if __name__ == '__main__':
    # If arguments are provided, use CLI mode and DO NOT read stdin
    if len(sys.argv) > 1:
        main()
        sys.exit(0)

    # Otherwise, expect JSON payload on stdin (PHP / CodeIgniter mode)
    try:
        stdin_data = sys.stdin.read()
    except Exception:
        stdin_data = ''

    if stdin_data and stdin_data.strip():
        # (optional) if you want to redirect print to stderr, keep this;
        # if not needed, you can remove this whole builtins/print override block
        try:
            import builtins
            _orig_print = builtins.print

            def _stderr_print(*args, **kwargs):
                return _orig_print(*args, file=sys.stderr, **kwargs)

            builtins.print = _stderr_print
        except Exception:
            _orig_print = None

        try:
            payload = json.loads(stdin_data)
            periodfromdate = payload.get('periodfromdate')
            periodtodate = payload.get('periodtodate')
            companyId = int(payload.get('company_id') or payload.get('companyId') or 0)
            upshare = int(payload.get('upshare') or 0)
            upsel = int(payload.get('upallsel') or payload.get('upsel') or 0)

            print(f"Received payload: from={periodfromdate}, to={periodtodate}, "
                  f"companyId={companyId}, upshare={upshare}, upsel={upsel}")

            # 👉 IMPORTANT: actually call your function and write JSON to STDOUT
            #result = gen_monthpfupdatapy(periodfromdate, periodtodate, companyId, upshare, upsel)
            sys.stdout.write(json.dumps(result, default=str))
        except Exception as e:
            # on error, output JSON error to stdout
            try:
                sys.stdout.write(json.dumps({"status": "error", "message": str(e)}))
            except Exception:
                pass

            if _orig_print:
                _orig_print("Exception in stdin handler:", e, file=sys.stderr)
        finally:
            # restore print if possible
            try:
                if _orig_print:
                    builtins.print = _orig_print
            except Exception:
                pass
        sys.exit(0)
    else:
        # no args, no stdin – nothing to do
        sys.stdout.write(json.dumps({"status": "error", "message": "No input provided"}))
        sys.exit(1)
