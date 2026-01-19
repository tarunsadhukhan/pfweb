<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Mpdf\Tag\Pre;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	

class Pfuploadfilegen extends CI_Controller {

	public function __construct() {
        parent::__construct();
		$this->load->database('db2');
		$this->load->model('Winding_doff_Model');
		$this->load->model('Pfupload_Model');
        $this->load->database('empmill12', TRUE);
	} 

	public function index()
	{
		$company_id = $this->session->userdata('company_id');

		if (strlen($company_id) == 0) { 
			redirect('admin/login/logout');
		}

		$this->load->library('form_validation');
		$this->load->model('Winding_doff_Model');
     
		$wndmcdata = $this->Winding_doff_Model->getwndmcnodata();
		$data['wndmcdata'] = $wndmcdata;
		
		$spooldata = $this->Winding_doff_Model->getSpooldata();
		$datas['spooldata'] = $spooldata;
	
		$qualitydata = $this->Winding_doff_Model->getQualitydata();
		$dataq['qualitydata'] = $qualitydata;

		$data_to_pass['data'] = $data;
		$data_to_pass['datas'] = $datas;
		$data_to_pass['dataq'] = $dataq;

		$this->load->view('admin/uandetails/Pfuploadfilegen', $data_to_pass);	
	}

    public function getuanname() {
        $uanno = $this->input->post('uanno');
        $companyId = $this->input->post('companyId');
        
        $result = $this->Pfupload_Model->getUanName($uanno, $companyId);
        
        $response = array(
            'success' => $result['found'],
            'name' => $result['name'],
            'uanid' => $result['uanid'],
        );
    
        echo json_encode($response);
    }
    
    public function getebname() {
        $ebno = $this->input->post('ebno');
        $companyId = $this->input->post('companyId');
        
        $result = $this->Pfupload_Model->getEbName($ebno, $companyId);
    
        $response = array(
            'success' => $result['found'],
            'name' => $result['name'],
            'uanid' => $result['uanid'],
            'ebfound' => $result['ebfound'],
            'uanno' => $result['uanno'],
            'pfno' => $result['pfno']
        );
    
        echo json_encode($response);
    }
 
    public function saveuan_data() {
        $incactdate = $this->input->post('incactdate');
        $uanno = $this->input->post('uanno');
        $uanname = $this->input->post('uanname');
        $ebno = $this->input->post('ebno');
        $adharseeded = $this->input->post('adharseeded');
        $uanactive = $this->input->post('uanactive');
        $pfno = $this->input->post('pfno');
        $companyId = $this->input->post('companyId');
        
        $incactdate = substr($incactdate, 6, 4) . '-' . substr($incactdate, 3, 2) . '-' . substr($incactdate, 0, 2);
        
        if ($uanactive == 1) {
            $incactdate = null;
        }
         
        $data = array(
            'uan_no' => $uanno,
            'name_as_per_pf_online' => $uanname,
            'pf_no' => $pfno,
            'uan_active' => $uanactive,
            'is_active' => 1,
            'adhar_seeded' => $adharseeded,
            'date_of_uan_inactive' => $incactdate,
            'eb_no' => $ebno,
            'company_id' => $companyId
        );
        
        $this->Pfupload_Model->insertUanMaster($data);
        
        $response = array(
            'success' => true,
            'savedata' => 'saved'
        );
    
        echo json_encode($response);
    }
 
    public function add_months($date) {
        $sdate = $date->format('Y-m-d');
        $mn = substr($sdate, 5, 2);
        $myr = substr($sdate, 0, 4);
        $ld = '';
        $yr = substr($sdate, 0, 4);
        $mn++;
      
        if ($mn > 12) { $mn = 1; $yr++; }
        
        switch ($mn) {
            case "01": $ld = '31'; break;
            case "02":
                $ld = '28';
                if ($myr % 4 == 0) { $ld = '29'; }
                break;
            case "03": $ld = '31'; break;
            case "04": $ld = '30'; break;
            case "05": $ld = '31'; break;
            case "06": $ld = '30'; break;
            case "07": $ld = '31'; break;
            case "08": $ld = '31'; break;
            case "09": $ld = '30'; break;
            case "10": $ld = '31'; break;
            case "11": $ld = '30'; break;
            case "12": $ld = '31'; break;
            default: break;
        }
        
        $sdate = $yr . '-' . $mn . '-' . $ld;
        $date = new DateTime($sdate);
        return $date->format('Y-m-d');
    }

    function format_date($date) {
        return $date->format('Y-m-d');
    }
    
    public function gen_monthpfupdatan() {
        echo 'kakak';

        $companyId = $this->input->post('companyId');
        $upfromdate = $this->input->post('upfromdate');
        $uptodate = $this->input->post('uptodate');
        $upshare = $this->input->post('upshare');
        $upallsel = $this->input->post('upallsel');
        $tableData = $this->input->post('tableData');
        $tableDataArray = json_decode($tableData, true);
        
        $pfgendate = $upfromdate;
        $start_date = substr($pfgendate, 6, 4) . '-' . substr($pfgendate, 3, 2) . '-' . substr($pfgendate, 0, 2);
    
        $pfgendate = $uptodate;
        $end_date = substr($pfgendate, 6, 4) . '-' . substr($pfgendate, 3, 2) . '-' . substr($pfgendate, 0, 2);
        
        $current_date = new DateTime($start_date);
        $end_date = new DateTime($end_date);
    }

    public function gen_createpfupdata() {
        $companyId = $this->input->post('companyId');
        $upfromdate = $this->input->post('upfromdate');
        $uptodate = $this->input->post('uptodate');
        $upshare = $this->input->post('upshare');
        $upallsel = $this->input->post('upallsel');
        $tableData = $this->input->post('tableData');
        $tableDataArray = json_decode($tableData, true);

        $pfgendate = $upfromdate;
        $start_date = substr($pfgendate, 6, 4) . '-' . substr($pfgendate, 3, 2) . '-' . substr($pfgendate, 0, 2);

        $pfgendate = $uptodate;
        $end_date = substr($pfgendate, 6, 4) . '-' . substr($pfgendate, 3, 2) . '-' . substr($pfgendate, 0, 2);
        
        $msg = 'NA';
        $batchpnos = '';
        $current_date = new DateTime($start_date);
        $end_date_obj = new DateTime($end_date);
    
        $gdate = $current_date->format('Y-m-d');
        $pfmonth = $current_date->format('m');
        $pfyear = $current_date->format('Y');
        $pfdays = $current_date->format('d');

        // Check if data already exists
        if ($this->Pfupload_Model->checkPfUploadExists($gdate, $upshare, $companyId)) {
            $response = array(
                'success' => false,
                'savedata' => 'PF Upload Data Already Created for the Month',
                'batchno' => $batchpnos,
            );
            echo json_encode($response);
            return;
        }
  
        $main = ($gdate <= '2025-08-31') ? 0 : 1;

        // Insert header
        $this->Pfupload_Model->insertPfHdrUploadData($gdate, $upshare, $companyId, $main);
        
        // Get max header ID
        $hdrInfo = $this->Pfupload_Model->getMaxPfHdrId();
        $maxpfhdrid = $hdrInfo['maxpfhdrid'];
        $mbno = $hdrInfo['mbatchno'];
        $batchpnos = $batchpnos . "," . $mbno;

        // Generate PF upload lines
        $this->genpfup11($companyId, $pfmonth, $pfyear, $pfdays, $gdate, $upshare, $maxpfhdrid);    

        // Get summary and update header
        $summary = $this->Pfupload_Model->getPfLineSummary($maxpfhdrid);
        $trnamt = $summary->pfcont + $summary->admchgs;
        $epfcont = $summary->epf_contribution + round($summary->eps_contribution * 1.67 / 10, 0);
        $epscont = round($summary->eps_contribution * 8.33 / 10, 0);
        
        if ($trnamt > 0) {
            $this->Pfupload_Model->updatePfHdrAmounts($maxpfhdrid, $trnamt, $epfcont, $epscont, $summary->admchgs);
        } else {
            $this->Pfupload_Model->updatePfHdrStatusInactive($maxpfhdrid);
        }

        $response = array(
            'success' => true,
            'savedata' => $msg,
            'batchno' => $batchpnos,
        );
    
        echo json_encode($response);
    }
    
    public function gen_monthpfupdatapy() {
        $companyId = $this->input->post('companyId');
        $upfromdate = $this->input->post('upfromdate');
        $uptodate = $this->input->post('uptodate');
        $upshare = $this->input->post('upshare');
        $upallsel = $this->input->post('upallsel');
        $tableData = $this->input->post('tableData');
        $tableDataArray = json_decode($tableData, true);

        $pfgendate = $upfromdate;
        $start_date = substr($pfgendate, 6, 4) . '-' . substr($pfgendate, 3, 2) . '-' . substr($pfgendate, 0, 2);

        $pfgendate = $uptodate;
        $end_date = substr($pfgendate, 6, 4) . '-' . substr($pfgendate, 3, 2) . '-' . substr($pfgendate, 0, 2);
        
        $batchpnos = '';
        
        $periodfromdate = $start_date;
        $periodtodate = $end_date;         
        $excfilename = "pfupdgen.py";
        
        $python = $this->config->item('python_bin', 'python');
        if (empty($python)) {
            $python = 'python';
        }
        
        $scriptPath = FCPATH . "Python\\" . $excfilename;

        $payload = json_encode([
            "periodfromdate" => $periodfromdate,
            "periodtodate" => $periodtodate,
            "company_id" => (int)$companyId,
            "upshare" => (int)$upshare,
            "upallsel" => (int)$upallsel,
            "tableData" => $tableDataArray
        ], JSON_UNESCAPED_SLASHES);

        $cmd = "\"$python\" \"$scriptPath\"";

        $descriptorspec = [
            0 => ["pipe", "r"],
            1 => ["pipe", "w"],
            2 => ["pipe", "w"],
        ];

        $process = proc_open($cmd, $descriptorspec, $pipes);

        if (!is_resource($process)) {
            echo json_encode(["success" => false, "reason" => "Unable to start python"]);
            return;
        }

        fwrite($pipes[0], $payload);
        fclose($pipes[0]);

        $stdout = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[2]);

        $exitCode = proc_close($process);

        $decoded = json_decode($stdout, true);

        if ($decoded === null) {
            $lines = preg_split("/\r\n|\n|\r/", trim($stdout));
            $last = end($lines);
            $maybe = json_decode($last, true);

            if ($maybe !== null) {
                $decoded = $maybe;
            } else {
                $decoded = [
                    'status' => 'error',
                    'message' => 'Invalid JSON from Python',
                    'raw_stdout' => $stdout,
                    'stderr' => $stderr,
                    'exit_code' => $exitCode
                ];
            }
        }

        $response = [
            'success' => true,
            'status' => isset($decoded['status']) ? $decoded['status'] : null,
            'processmonth' => isset($decoded['processmonth']) ? $decoded['processmonth'] : [],
            'batchno' => $batchpnos ?? '',
            'python_stderr' => $stderr,
            'python_exit' => $exitCode
        ];

        echo json_encode($response);
    }

    public function gen_monthpfupdata() {
        $companyId = $this->input->post('companyId');
        $upfromdate = $this->input->post('upfromdate');
        $uptodate = $this->input->post('uptodate');
        $upshare = $this->input->post('upshare');
        $upallsel = $this->input->post('upallsel');
        $tableData = $this->input->post('tableData');
        $tableDataArray = json_decode($tableData, true);

        $pfgendate = $upfromdate;
        $start_date = substr($pfgendate, 6, 4) . '-' . substr($pfgendate, 3, 2) . '-' . substr($pfgendate, 0, 2);

        $pfgendate = $uptodate;
        $end_date = substr($pfgendate, 6, 4) . '-' . substr($pfgendate, 3, 2) . '-' . substr($pfgendate, 0, 2);
        
        $msg = 'NA';
        $batchpnos = '';
        $current_date = new DateTime($start_date);
        $end_date_obj = new DateTime($end_date);
 
        $pfprvdate = '2025-08-31';
    
        while ($current_date <= $end_date_obj) {
            $gdate = $current_date->format('Y-m-d');
            $pfmonth = $current_date->format('m');
            $pfyear = $current_date->format('Y');
            $pfdays = $current_date->format('d');

            $curhdrid = 0;
            
            // Check existing header
            $curhdrid = $this->Pfupload_Model->getPfUploadHeader($gdate, $upshare, $companyId);
            
            if ($curhdrid == 0 && $gdate > $pfprvdate) {
                $msg = "Create All Data for the Month First";
                $response = array(
                    'success' => false,
                    'savedata' => $msg,
                    'batchno' => 0,
                );
                echo json_encode($response);
                return;
            }
 
            // Determine transaction type
            $trtp = '1';
            if ($upshare == 2) { $trtp = '1,2'; }
            if ($upshare == 3) { $trtp = '1,3'; }
            
            $ocnt = 0;
            $ccnt = 0;
            
            if ($gdate <= $pfprvdate) {
                $ocnt = $this->Pfupload_Model->getPendingPfGenDataOld($gdate, $companyId, $trtp);
            } else {
                $ccnt = $this->Pfupload_Model->getPendingPfGenDataNew($gdate, $companyId, $trtp);
            }

            if (($ocnt + $ccnt) == 0) {
                $msg = "Already All Data Generated/No PF Generation Data Found for the Month";
                $response = array(
                    'success' => false,
                    'savedata' => $msg,
                    'batchno' => 0,
                );
                echo json_encode($response);
                return;
            }
 
            // Insert header
            $this->Pfupload_Model->insertPfHdrUploadData($gdate, $upshare, $companyId, 9);
            
            // Get max header ID
            $hdrInfo = $this->Pfupload_Model->getMaxPfHdrId();
            $maxpfhdrid = $hdrInfo['maxpfhdrid'];
            $mbno = $hdrInfo['mbatchno'];
            $batchpnos = $batchpnos . "," . $mbno;

            // Process based on selection type
            if ($upallsel == 1) {
                if ($upshare == 1) {
                    $this->genpfup111($companyId, $pfmonth, $pfyear, $pfdays, $gdate, $upshare, $maxpfhdrid, $pfprvdate, $curhdrid);    
                } 
                if ($upshare == 2) {
                    $this->genpfup12($companyId, $pfmonth, $pfyear, $pfdays, $gdate, $upshare, $maxpfhdrid, $pfprvdate, $curhdrid);    
                } 
                if ($upshare == 3) {
                    $this->genpfup13($companyId, $pfmonth, $pfyear, $pfdays, $gdate, $upshare, $maxpfhdrid, $pfprvdate, $curhdrid);
                } 
            }
            
            if ($upallsel == 2) {
                if ($upshare == 1) {
                    $this->genpfup21($companyId, $pfmonth, $pfyear, $pfdays, $gdate, $upshare, $maxpfhdrid, $tableDataArray);    
                } 
                if ($upshare == 2) {
                    $this->genpfup22($companyId, $pfmonth, $pfyear, $pfdays, $gdate, $upshare, $maxpfhdrid, $tableDataArray);    
                } 
                if ($upshare == 3) {
                    $this->genpfup23($companyId, $pfmonth, $pfyear, $pfdays, $gdate, $upshare, $maxpfhdrid, $tableDataArray);    
                } 
            }

            // Get summary and update header
            $summary = $this->Pfupload_Model->getPfLineSummaryGross($maxpfhdrid);
            $trnamt = $summary->pfcont + $summary->admchgs;
            $epfcont = $summary->epf_contribution + round($summary->eps_contribution * 1.67 / 100, 0);
            $epscont = round($summary->eps_contribution * 8.33 / 100, 0);
            
            if ($trnamt > 0) {
                $this->Pfupload_Model->updatePfHdrAmounts($maxpfhdrid, $trnamt, $epfcont, $epscont, $summary->admchgs);
            } else {
                $this->Pfupload_Model->updatePfHdrStatusInactive($maxpfhdrid);
            }

            $current_date = $this->add_months($current_date);
            $current_date = new DateTime($current_date);
        }

        $msg = 'PF Upload Data Generated Successfully';
        $response = array(
            'success' => true,
            'savedata' => $msg,
            'batchno' => $batchpnos,
        );
    
        echo json_encode($response);
    } 

    function genpfup11($companyId, $pfmonth, $pfyear, $pfdays, $gdate, $upshare, $maxpfhdrid) {
        $this->Pfupload_Model->insertPfLineAllOld($maxpfhdrid, $gdate, $companyId);
    }

    function genpfup111($companyId, $pfmonth, $pfyear, $pfdays, $gdate, $upshare, $maxpfhdrid, $pfprvdate, $curhdrid) {
        if ($gdate <= $pfprvdate) { 
            $this->Pfupload_Model->insertPfLineAllOld($maxpfhdrid, $gdate, $companyId);
        } else {
            $this->Pfupload_Model->insertPfLineAllNew($maxpfhdrid, $curhdrid);
        }
    }

    function genpfup12($companyId, $pfmonth, $pfyear, $pfdays, $gdate, $upshare, $maxpfhdrid, $pfprvdate, $curhdrid) {
        if ($gdate <= $pfprvdate) {
            $this->Pfupload_Model->insertPfLineEpfOnlyOld($maxpfhdrid, $gdate, $companyId);
        } else {
            $this->Pfupload_Model->insertPfLineEpfOnlyNew($maxpfhdrid,$gdate, $curhdrid);
        }
    }

    function genpfup13($companyId, $pfmonth, $pfyear, $pfdays, $gdate, $upshare, $maxpfhdrid, $pfprvdate, $curhdrid) {
        if ($gdate <= $pfprvdate) {        
            $this->Pfupload_Model->insertPfLineEpsOnlyOld($maxpfhdrid, $gdate, $companyId);
        } else {
            $this->Pfupload_Model->insertPfLineEpsOnlyNew($maxpfhdrid, $curhdrid);
        }
    }

    function genpfup21($companyId, $pfmonth, $pfyear, $pfdays, $gdate, $upshare, $maxpfhdrid, $tableDataArray) {
        $uanIds = array_column($tableDataArray, 0);
        $this->Pfupload_Model->insertPfLineSelectedAll($maxpfhdrid, $gdate, $companyId, $uanIds);
    }

    function genpfup22($companyId, $pfmonth, $pfyear, $pfdays, $gdate, $upshare, $maxpfhdrid, $tableDataArray) {
        $uanIds = array_column($tableDataArray, 0);
        $this->Pfupload_Model->insertPfLineSelectedEpf($maxpfhdrid, $gdate, $companyId, $uanIds);
    }
 
    function genpfup23($companyId, $pfmonth, $pfyear, $pfdays, $gdate, $upshare, $maxpfhdrid, $tableDataArray) {
        $uanIds = array_column($tableDataArray, 0);
        $this->Pfupload_Model->insertPfLineSelectedEps($maxpfhdrid, $gdate, $companyId, $uanIds);
    }

    public function get_pfgendata() {
        $compid = $this->session->userdata('company_id');
        $pfgendate = $this->input->post('pfgendate');
        $pfgendate = substr($pfgendate, 6, 4) . '-' . substr($pfgendate, 3, 2) . '-' . substr($pfgendate, 0, 2);
 
        $records = $this->Pfupload_Model->getPfGenData($pfgendate, $compid);
        
        $data = [];
        foreach ($records as $record) {
            $data[] = [
                $record->pf_gen_id,
                $record->uan_no,
                $record->name_as_per_pf_online,
                $record->gross_wages,
                $record->epf_wages,
                $record->eps_wages,
                $record->edli_wages,
                $record->epf_contibution,
                $record->eps_contribution,
                $record->epf_eps_diff_contribution,
                $record->ncp_days,
                $record->remarks,
            ];
        }
        
        // Get totals
        $totalRecord = $this->Pfupload_Model->getPfGenDataTotals($pfgendate);
        
        $data[] = [
            '',
            $totalRecord->uan_no,
            $totalRecord->name_as_per_pf_online,
            $totalRecord->gross_wages,
            $totalRecord->epf_wages,
            $totalRecord->eps_wages,
            $totalRecord->edli_wages,
            $totalRecord->epf_contibution,
            $totalRecord->eps_contribution,
            $totalRecord->epf_eps_diff_contribution,
            $totalRecord->ncp_days,
            $totalRecord->remarks,
        ];

        echo json_encode(['data' => $data]);
    }

    public function cancel_monthpfdata() {
        $pfgendate = $this->input->post('pfgendate');
        $pfgendate = substr($pfgendate, 6, 4) . '-' . substr($pfgendate, 3, 2) . '-' . substr($pfgendate, 0, 2);
        $companyId = $this->input->post('companyId');
        
        $this->Pfupload_Model->cancelPfGenData($pfgendate, $companyId);
    
        $response = array(
            'success' => true,
            'savedata' => 'saved'
        );
    
        echo json_encode($response);
    }
 
    public function get_pfdataexists() {
        $compid = $this->session->userdata('company_id');
        $pfgendate = $this->input->post('pfgendate');
        $pfgendate = substr($pfgendate, 6, 4) . '-' . substr($pfgendate, 3, 2) . '-' . substr($pfgendate, 0, 2);
  
        $sln = $this->Pfupload_Model->checkPfDataExists($pfgendate);
    
        $response = array(
            'success' => true,
            'savedata' => 'checked',
            'noofrows' => $sln
        );
            
        echo json_encode($response);
    }

    public function updateuan_data() {
        $incactdate = $this->input->post('incactdate');
        $uanno = $this->input->post('uanno');
        $uanname = $this->input->post('uanname');
        $ebno = $this->input->post('ebno');
        $adharseeded = $this->input->post('adharseeded');
        $uanactive = $this->input->post('uanactive');
        $pfno = $this->input->post('pfno');
        $record_id = $this->input->post('record_id');
        $companyId = $this->input->post('companyId');
        
        $incactdate = substr($incactdate, 6, 4) . '-' . substr($incactdate, 3, 2) . '-' . substr($incactdate, 0, 2);
        
        if ($uanactive == 1) {
            $incactdate = null;
        }
         
        $data = array(
            'uan_no' => $uanno,
            'name_as_per_pf_online' => $uanname,
            'pf_no' => $pfno,
            'uan_active' => $uanactive,
            'is_active' => 1,
            'adhar_seeded' => $adharseeded,
            'date_of_uan_inactive' => $incactdate,
            'eb_no' => $ebno,
            'company_id' => $companyId
        );
        
        $this->Pfupload_Model->updateUanMaster($record_id, $data);
    
        $response = array(
            'success' => true,
            'savedata' => 'Updated'
        );
    
        echo json_encode($response);
    }

    public function gen_excelpfdata() {
        $sdate = $this->input->get('doffrepdate');
        $compid = $this->input->get('companyId');

        $date = substr($sdate, 6, 4) . '-' . substr($sdate, 3, 2) . '-' . substr($sdate, 0, 2);
        $pfgendate = $date;
      
        $records = $this->Pfupload_Model->getPfGenDataForExcel($pfgendate, $compid);
 
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'For the Month of ' . $sdate);
        $sheet->setCellValue('A2', 'UAN No ');
        $sheet->setCellValue('B2', 'Name');
        $sheet->setCellValue('C2', 'Gross Wages');
        $sheet->setCellValue('D2', 'EPF Wages');
        $sheet->setCellValue('E2', 'EPS Wages');
        $sheet->setCellValue('F2', 'EDLI Wages');
        $sheet->setCellValue('G2', 'EPF Cont');
        $sheet->setCellValue('H2', 'EPS Cont');
        $sheet->setCellValue('I2', 'EPF EPS Diff');
        $sheet->setCellValue('J2', 'NCP Days');
        $sheet->setCellValue('K2', 'Remarks');
        $sheet->setCellValue('L2', 'Pay Schm Id');
    
        $rowIndex = 3;
        foreach ($records as $record) {
            $columnIndex = 1;
            $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->uan_no);
            $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->name_as_per_pf_online);
            $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->gross_wages);
            $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->epf_wages);
            $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->eps_wages);
            $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->edli_wages);
            $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->epf_contibution);
            $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->eps_contribution);
            $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->epf_eps_diff_contribution);
            $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->ncp_days);
            $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->remarks);
            $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->psch_id);
            $rowIndex++;
        }	

        $filename = "pfdata_" . $date . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename);
        header('Cache-Control: max-age=0');
        ob_clean();

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function gen_createpfupdatapy() {
        $companyId = $this->input->post('companyId');
        $upfromdate = $this->input->post('upfromdate');
        $uptodate = $this->input->post('uptodate');
        $upshare = $this->input->post('upshare');
        $upallsel = $this->input->post('upallsel');
        $tableData = $this->input->post('tableData');
        $tableDataArray = json_decode($tableData, true);

        $pfgendate = $upfromdate;
        $start_date = substr($pfgendate, 6, 4) . '-' . substr($pfgendate, 3, 2) . '-' . substr($pfgendate, 0, 2);

        $pfgendate = $uptodate;
        $end_date = substr($pfgendate, 6, 4) . '-' . substr($pfgendate, 3, 2) . '-' . substr($pfgendate, 0, 2);
        
        $batchpnos = '';

        $payload = [
            "companyId" => $companyId,
            "upfromdate" => $start_date,
            "uptodate" => $end_date,
            "upshare" => $upshare,
            "upallsel" => $upallsel,
            "tableData" => $tableDataArray
        ];

        $py = "d:\\python311\\python.exe";
        $script = "D:\\pyproj\\pytst\\createpfdatapy.py";

        $tmpDir = FCPATH . "tmp\\";
        if (!is_dir($tmpDir)) {
            @mkdir($tmpDir, 0777, true);
        }

        $payloadFile = $tmpDir . "pf_payload_" . date("Ymd_His") . "_" . mt_rand(1000, 9999) . ".json";
        $responseFile = $tmpDir . "pf_response_" . date("Ymd_His") . "_" . mt_rand(1000, 9999) . ".json";

        file_put_contents($payloadFile, json_encode($payload, JSON_UNESCAPED_UNICODE));

        $cmd = "\"{$py}\" \"{$script}\" \"{$payloadFile}\" \"{$responseFile}\" 2>&1";
        $output = shell_exec($cmd);

        if (!file_exists($responseFile)) {
            @unlink($payloadFile);
            echo json_encode([
                'success' => false,
                'savedata' => "Python did not create response file. Output: " . $output,
                'batchno' => ''
            ]);
            return;
        }

        $pyRespRaw = file_get_contents($responseFile);
        $pyResp = json_decode($pyRespRaw, true);

        @unlink($payloadFile);
        @unlink($responseFile);

        if (!is_array($pyResp)) {
            echo json_encode([
                'success' => false,
                'savedata' => "Invalid JSON from python. Raw: " . $pyRespRaw,
                'batchno' => ''
            ]);
            return;
        }

        echo json_encode([
            'success' => (bool)($pyResp['success'] ?? false),
            'savedata' => $pyResp['message'] ?? 'NA',
            'batchno' => $pyResp['batchno'] ?? ''
        ]);
    }

}
