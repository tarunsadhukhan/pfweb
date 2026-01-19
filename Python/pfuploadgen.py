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


def month(periodfromdate, periodtodate):
    """Return list of month-end dates between two dates (inclusive)."""

    def to_date(d):
        if isinstance(d, datetime):
            return d.date()
        if isinstance(d, str):
            for fmt in ("%Y-%m-%d", "%Y-%m", "%d-%m-%Y", "%d/%m/%Y"):
                try:
                    return datetime.strptime(d, fmt).date()
                except Exception:
                    continue
            raise ValueError(f"Unsupported date format: {d}")
        return d

    start = to_date(periodfromdate)
    end = to_date(periodtodate)

    if start > end:
        start, end = end, start

    months = []
    cur_year = start.year
    cur_month = start.month

    while True:
        last_day = calendar.monthrange(cur_year, cur_month)[1]
        month_end = datetime(cur_year, cur_month, last_day).date()

        if month_end > end:
            break

        months.append(month_end)

        if cur_month == 12:
            cur_month = 1
            cur_year += 1
        else:
            cur_month += 1

        if datetime(cur_year, cur_month, 1).date() > end:
            break

    return months


from datetime import datetime

def is_previous_month(month_end, prevdate):
    """Check if the month_end is less than or equal to prevdate."""
    pf_date = datetime.strptime(prevdate, "%Y-%m-%d").date()
    return month_end <= pf_date

def rule_prev_0_1_1(month_end, companyId, upshare, cursor):
    sql="""SELECT
                    tpg.*,
                    NULL AS puanid
                FROM EMPMILL12.tbl_pf_generation tpg
                JOIN EMPMILL12.tbl_uan_master tum
                    ON tum.uan_id = tpg.uan_id
                WHERE
                    tpg.month_end_date = %s
                    AND tpg.is_active = 1
                    AND tpg.company_id = %s
                    AND tum.adhar_seeded = 1
                    AND NOT EXISTS (
                        SELECT 1
                        FROM EMPMILL12.tbl_pf_hdr_upload_data tphud
                        JOIN EMPMILL12.tbl_pf_line_upload_data tplud
                            ON tphud.pf_hdr_upload_id = tplud.pf_hdr_upload_id
                        AND tplud.is_active = 1
                        WHERE
                            tphud.trrn_status IN (2,3)
                            AND tphud.company_id = %s
                            AND tphud.trrn_type IN (%s)
                            AND tphud.is_active = 1
                            AND tphud.month_end_date = %s
                            AND tplud.uan_id = tpg.uan_id
                    )
"""
    #print(f"Executing rule_prev_0_1_1 SQL with month_end={month_end}, companyId={companyId}, upshare={upshare}")    
    #print(sql)
    cursor.execute(sql, (month_end, companyId, companyId, upshare, month_end))
    # fetch results and print details for inspection
    try:
        rows = cursor.fetchall()
        #print(f"rule_prev_0_1_1: fetched {len(rows)} rows")
        for i, r in enumerate(rows, start=1):
            print(f"row {i}: {r}")
            if i >= 50:
                print("...truncated further rows...")
                break
    except Exception:
        try:
            row = cursor.fetchone()
            if row:
                print("rule_prev_0_1_1: fetched 1 row:", row)
            else:
                print("rule_prev_0_1_1: no rows fetched")
        except Exception:
            print("rule_prev_0_1_1: failed to fetch rows for inspection")

    return "AND trrn_status IN (2,3) AND trrn_type=1"

def rule_prev_0_1_2(month_end, companyId, upshare, cursor):
    sql="""SELECT
                    tpg.*,
                    NULL AS puanid
                FROM EMPMILL12.tbl_pf_generation tpg
                JOIN EMPMILL12.tbl_uan_master tum
                    ON tum.uan_id = tpg.uan_id
                WHERE
                    tpg.month_end_date = %s
                    AND tpg.is_active = 1
                    AND tpg.company_id = %s
                    AND tum.adhar_seeded = 1
                    AND NOT EXISTS (
                        SELECT 1
                        FROM EMPMILL12.tbl_pf_hdr_upload_data tphud
                        JOIN EMPMILL12.tbl_pf_line_upload_data tplud
                            ON tphud.pf_hdr_upload_id = tplud.pf_hdr_upload_id
                        AND tplud.is_active = 1
                        WHERE
                            tphud.trrn_status IN (2,3)
                            AND tphud.company_id = %s
                            AND tphud.trrn_type IN (%s)
                            AND tphud.is_active = 1
                            AND tphud.month_end_date = %s
                            AND tplud.uan_id = tpg.uan_id
                    )
"""
    #print(f"Executing rule_prev_0_1_2 SQL with month_end={month_end}, companyId={companyId}, upshare={upshare}")    
    #print(sql)
    cursor.execute(sql, (month_end, companyId, companyId, upshare, month_end))
    # fetch results and print details for inspection
    try:
        rows = cursor.fetchall()
        #print(f"rule_prev_0_1_2: fetched for {month_end} {len(rows)} rows")
        for i, r in enumerate(rows, start=1):
            #print(f"row {i}: {r}")
            if i >= 50:
                #print("...truncated further rows...")
                break
    except Exception:
        try:
            row = cursor.fetchone()
            if row:
                print("rule_prev_0_1_2: fetched 1 row:", row)
            else:
                print("rule_prev_0_1_2: no rows fetched")
        except Exception:
            print("rule_prev_0_1_2: failed to fetch rows for inspection")
    return "AND trrn_status IN (2) AND trrn_type=2"

def rule_prev_0_1_3():
    return "AND trrn_status IN (3) AND trrn_type=3"

def rule_prev_0_2_1():
    return "AND trrn_status IN (2,3)"

def rule_prev_0_2_2():
    return "AND trrn_status IN (2,3)"

def rule_prev_0_2_3():
    return "AND trrn_status IN (2,3)"

def rule_prev_1_1_1():
    return "AND trrn_status IN (2,3) AND trrn_type=1"

def rule_prev_1_1_2():
    return "AND trrn_status IN (2) AND trrn_type=2"

def rule_prev_1_1_3():
    return "AND trrn_status IN (3) AND trrn_type=3"

def rule_prev_1_2_1():
    return "AND trrn_status IN (2,3)"

def rule_prev_1_2_2():
    return "AND trrn_status IN (2,3)"

def rule_prev_1_2_3():
    return "AND trrn_status IN (2,3)"
    return "AND trrn_status IN (2,3) AND trrn_type=1"

def rule_prev_2_1():
    return "AND trrn_status IN (2) AND trrn_type=2"

def rule_prev_3_1():
    return "AND trrn_status IN (3) AND trrn_type=3"

def rule_prev_1_2():
    return "AND trrn_status IN (2,3)"

def rule_default():
    return "AND 1=0"   # safety


PREVIOUS_MONTH_RULES = {
    (0,1, 1): rule_prev_0_1_1,
    (0,1, 2): rule_prev_0_1_2,
    (0,1, 3): rule_prev_0_1_3,
    (0,2, 1): rule_prev_0_2_1,
    (0,2, 2): rule_prev_0_2_2,
    (0,2, 3): rule_prev_0_2_3,
    (1,1, 1): rule_prev_1_1_1,
    (1,1, 2): rule_prev_1_1_2,
    (1,1, 3): rule_prev_1_1_3,
    (1,2, 1): rule_prev_1_2_1,
    (1,2, 2): rule_prev_1_2_2,
    (1,2, 3): rule_prev_1_2_3
    
}

def build_sql(month_end, companyId,upsel, upshare,  pfprvdate, cursor=None):
    base_sql = """
        SELECT *
        FROM EMPMILL12.tbl_pf_hdr_upload_data
        WHERE MONTH(month_end_date)=%s
          AND YEAR(month_end_date)=%s
          AND company_id=%s
          AND is_active=1
    """

    is_prev = is_previous_month(month_end, pfprvdate)
    if is_prev:
        prvm = 0
    else:
        prvm = 1
        
    #print(f"Building SQL for month_end={month_end}, is_prev={is_prev}, upshare={upshare}, upsel={upsel}")
    rule_func = PREVIOUS_MONTH_RULES.get((prvm, upsel, upshare), rule_default) if is_prev else lambda: ""
    #print(f"Selected rule function: {rule_func.__name__ if rule_func else 'None'}")
    # call rule function with parameters if it accepts them (some rules may execute additional queries)
    clause = ""
    if is_prev and rule_func:
        try:
            # try calling with (month_end, companyId, upshare, cursor)
            clause = rule_func(month_end, companyId, upshare, cursor)
        except TypeError:
            # fallback: call without params
            clause = rule_func()

    final_sql = base_sql + " " + clause + " ORDER BY month_end_date"
    return final_sql

def check_already_processed(cursor, month_end, companyId, upshare, upsel, pfprvdate):
    if not is_previous_month(month_end, pfprvdate):
        return False

    sql = """
        SELECT COUNT(*) AS noofrec
        FROM EMPMILL12.tbl_pf_hdr_upload_data
        WHERE MONTH(month_end_date)=%s
          AND YEAR(month_end_date)=%s
          AND company_id=%s
          AND is_active=1
          AND trrn_status IN (2,3)
          AND trrn_type=%s
    """
    cursor.execute(sql, (month_end.month, month_end.year, companyId, upshare))
    row = cursor.fetchone()
    return row and row.get("noofrec", 0) > 0

def process_month(month_end, companyId, cursor, conn, upshare, upsel):
    pfprvdate = "2025-08-31"
    response = {
        "month": str(month_end),
        "status": None,
        "records": 0,
        "is_previous_month": is_previous_month(month_end, pfprvdate)
    }

    # Check already processed
    if check_already_processed(cursor, month_end, companyId, upshare, upsel, pfprvdate):
        print(f"Skipping {month_end} (already processed)")
        response["status"] = "already_processed"
        return response

    # Build SQL based on criteria (pass cursor so rule functions can run checks)
    sql = build_sql(month_end, companyId, upshare, upsel, pfprvdate, cursor)
    cursor.execute(sql, (month_end.month, month_end.year, companyId))

    idx = 0
    while True:
        row = cursor.fetchone()
        if not row:
            break

        idx += 1
        trrn_no = row.get('trrn_no') or row.get('tran_no')
        amount = row.get('trrn_amount') or row.get('amount')
        print(f"Month {month_end} - Record {idx}: trrn_no={trrn_no}, amount={amount}")
        response["records"] += 1

    response["status"] = "processed" if response["records"] > 0 else "no_data"
    return response


def gen_monthpfupdatapy(periodfromdate, periodtodate, companyId, upshare, upsel):
    try:
        conn = get_connection()
        cursor = conn.cursor(dictionary=True)

        months = month(periodfromdate, periodtodate)
        already_processed_months = []
        #print(f"Processing months: {months} {periodfromdate} to {periodtodate} for companyId={companyId}, upshare={upshare}, upsel={upsel}  ")
        for m in months:
            #print(f"Processing month: {m}")
            result = process_month(m, companyId, cursor, conn, upshare, upsel)
            if result["status"] == "already_processed":
                already_processed_months.append(result["month"])
            time.sleep(0.05)

        return {
            "status": "already_processed" if already_processed_months else "processed",
            "processmonth": already_processed_months,
            "companyId": companyId,
            "upshare": upshare,
            "upsel": upsel
        }

    except Exception as e:
        traceback.print_exc()
        return {"status": "error", "message": str(e)}

    finally:
        try:
            cursor.close()
        except Exception:
            pass
        try:
            conn.close()
        except Exception:
            pass


def main(argv=None):
    if argv is None:
        argv = sys.argv[1:]

    if len(argv) < 3:
        print("Usage: pfuploadgen.py <from> <to> <companyId> [upshare] [upsel]")
        return

    periodfromdate = argv[0]
    periodtodate = argv[1]
    companyId = int(argv[2])
    upshare = int(argv[3]) if len(argv) > 3 else 0
    upsel = int(argv[4]) if len(argv) > 4 else 0

    result = gen_monthpfupdatapy(periodfromdate, periodtodate, companyId, upshare, upsel)
    print(json.dumps(result, default=str, indent=2))

if __name__ == '__main__':
    # If JSON payload is provided on stdin (used by the PHP caller), read it
    try:
        stdin_data = sys.stdin.read()
    except Exception:
        stdin_data = ''

    if stdin_data and stdin_data.strip():
        # Route debug prints to stderr so stdout remains clean for JSON response
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
            print (f"Received payload: from={periodfromdate}, to={periodtodate}, companyId={companyId}, upshare={upshare}, upsel={upsel}")
            result = gen_monthpfupdatapy(periodfromdate, periodtodate, companyId, upshare, upsel)
            # write only JSON to stdout
            sys.stdout.write(json.dumps(result, default=str))
        except Exception as e:
            # on error, output JSON error to stdout and debug to stderr
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
        main()
