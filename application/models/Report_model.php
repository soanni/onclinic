<?php

    class Report_model extends CI_Model{
        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        public function getPatients(){
            $str = 'SELECT patient_id,CONCAT_WS(", ",CONCAT(UCASE(LEFT(firstname, 1)), LCASE(SUBSTRING(firstname, 2))) ,CONCAT(UCASE(LEFT(lastname, 1)), LCASE(SUBSTRING(lastname, 2)))) AS fullname FROM onclinic.patients';
            $query = $this->db->query($str);
            $arr = $query->result_array();
            return $this->transform($arr);
        }

        public function getDoctors(){
            $arr = $this->db->get('doctors')->result_array();
            return $this->transform($arr);
        }

        public function getTests(){
            $select = "SELECT
                            t.testid
                            ,t.testname
                            ,t.range_min
                            ,t.range_max
                            ,t.unitid
                            ,u.unitname
                       FROM  onclinic.tests t
                       INNER JOIN onclinic.units u ON t.unitid = u.unitid";
            $query = $this->db->query($select);
            $arr = $query->result_array();
            return $this->transform($arr);
        }

        public function insertReportWithDetails($details){
            $data = array(
                'doctorid' => $details['doctor'],
                'patientid' => $details['patient'],
                'created' => date('Y-m-j H:i:s'),
                'comment' => $this->db->escape($details['comment']),
                'changedate' => date('Y-m-j H:i:s')
            );
            if($this->db->insert('reports',$data)){
                // get the id of the new report just created
                $id = $this->db->insert_id();
                $count = count($details['test']);
                for($i = 0; $i < $count; $i++){
                    if($this->insertDetailsRow($id, $details['patient'],$details['test'][$i], $details['result'][$i],$details['test_comment'][$i])){
                        continue;
                    }else{
                        return 0;
                    }
                }
                return 1;
            }else{
                return 0;
            }
        }

        public function get_reports_list($patientid){
            if(!is_null($patientid)){
                $select = "SELECT
                            r.reportid,
                            p.firstname,
                            p.lastname,
                            p.ssn,
                            p.telephone,
                            p.email,
                            r.created,
                            d.doctorname
                          FROM onclinic.reports r
                          INNER JOIN onclinic.patients p ON r.patientid = p.patient_id
                          INNER JOIN onclinic.doctors d ON r.doctorid = d.doctorid
                          WHERE r.patientid = {$patientid}
                          ORDER BY p.lastname ASC, r.created DESC";
            }else{
                $select = 'SELECT
                            r.reportid,
                            p.firstname,
                            p.lastname,
                            p.ssn,
                            p.telephone,
                            p.email,
                            r.created,
                            d.doctorname
                          FROM onclinic.reports r
                          INNER JOIN onclinic.patients p ON r.patientid = p.patient_id
                          INNER JOIN onclinic.doctors d ON r.doctorid = d.doctorid
                          ORDER BY p.lastname ASC, r.created DESC';
            }
            return $this->db->query($select)->result_array();
        }

        public function getReportHead($reportid){
                $select = "SELECT
                            r.reportid,
                            p.firstname,
                            p.lastname,
                            p.ssn,
                            p.telephone,
                            p.email,
                            r.created,
                            d.doctorname,
                            r.comment
                           FROM onclinic.reports r
                           INNER JOIN onclinic.patients p ON r.patientid = p.patient_id
                           INNER JOIN onclinic.doctors d ON r.doctorid = d.doctorid
                           WHERE r.reportid = {$reportid}";
                return $this->db->query($select)->result_array();
        }

        public function getReportDetails($reportid){
            $select = "SELECT
                        r.testid,
                        t.testname,
                        r.value,
                        t.range_min,
                        t.range_max,
                        t.unitid,
                        u.unitname,
                        r.testcomment
                       FROM onclinic.reports_items r
                       LEFT JOIN onclinic.tests t ON r.testid = t.testid
                       LEFT JOIN onclinic.units u ON t.testid = u.unitid
                       WHERE r.reportid = {$reportid}";
            return $this->db->query($select)->result_array();
        }

        //////////////////////////
        private function transform($arr){
            $transformed = array();
            foreach($arr as $row){
                $keys = array_keys($row);
                $transformed[$row[$keys[0]]] = $row[$keys[1]];
            }
            return $transformed;
        }

        private function insertDetailsRow($reportid, $patientid, $testid, $result,$comment){
            $data = array(
                'reportid' => $reportid,
                'patientid' => $patientid,
                'testid' => $testid,
                'value' => $result,
                'testcomment'=> $this->db->escape($comment)
            );
            return $this->db->insert('reports_items',$data);
        }
    }