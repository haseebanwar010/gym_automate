<?php
class Expenses_model extends CI_Model {
    public function __construct(){
        $this->load->database();
    }
    public function addexpenses($image = false){
        $this->load->helper('url');
        $expensedata = array();
        $expensedetaildata = array();
        if($this->input->post('expense_date')){
            $licount=$this->input->post('licounter');
            $expenses=array();
            $totlaexpenseinput=0;
            for($i=0;$i<=$licount;$i++){
                $expenses[]=array(
                    'expense_title' => $this->input->post('expense_title'.$i) ,
                    'expense_amount' => $this->input->post('expense_amount'.$i)
                );
                $totlaexpenseinput=$totlaexpenseinput+$this->input->post('expense_amount'.$i);
            }
            /*comparison of date for tbl_expenses_details_ start*/
            $comparisondate=date('Y-m-d',strtotime($this->input->post('expense_date')));
            $gymid=$this->session->userdata('userid');
            $tablename="tbl_expenses_details_".$gymid;
            $query = $this->db->get_where($tablename, array('expense_date' => $comparisondate ));
            $checkdate=$query->result_array();
            if(empty($checkdate)){
                $expensedetaildata['expense_date']=$comparisondate;
                $expensedetaildata['expenses']=serialize($expenses);
                $this->db->insert($tablename, $expensedetaildata);
            }
            else{
                $unserializeddata=unserialize($checkdate[0]['expenses']);
                for($j=0;$j<sizeof($unserializeddata);$j++){
                    $expenses[]=$unserializeddata[$j];
                }
                $expensedetaildata['expense_date']=$comparisondate;
                $expensedetaildata['expenses']=serialize($expenses);
                $this->db->where('id', $checkdate[0]['id']);
                $this->db->update($tablename, $expensedetaildata);
            }
            /*comparison of date for tbl_expenses_details_ end*/
    
            /*comparison of date for tbl_expenses_ start*/
            $comparisondatetwo=date('Y-m-1',strtotime($this->input->post('expense_date')));
            $tablenametwo="tbl_expenses_".$gymid;
            $query = $this->db->get_where($tablenametwo, array('month_date' => $comparisondatetwo ));
            $checkdatetwo=$query->result_array();
            if(empty($checkdatetwo)){
                $expensedata['month_date']=$comparisondatetwo;
                $expensedata['total_expence']=$totlaexpenseinput;
                return $this->db->insert($tablenametwo, $expensedata);
            }
            else{
                $expensedata['total_expence']=$totlaexpenseinput+$checkdatetwo[0]['total_expence'];
                $this->db->where('month_date', $comparisondatetwo);
                return $this->db->update($tablenametwo, $expensedata);
            }
            /*comparison of date for tbl_expenses_ end*/
        }
    }
    public function get_expenses($filterdata=NULL){
        $gymid=$this->session->userdata('userid');
        $tablename="tbl_expenses_details_".$gymid;
        if($filterdata==NULL){
            $comparisonstartdate=date('Y-m-1');
            $comparisonenddate=date('Y-m-30');
        }
        else{
            $comparisonstartdate=$filterdata['start_date'];
            $comparisonenddate=$filterdata['end_date'];
        }
        $query=$this->db->where('`expense_date` BETWEEN "'. $comparisonstartdate. '" AND "'. $comparisonenddate.'"')->get($tablename);
        $result=$query->result_array();
        return $result;
    }
    public function get_balancesheet_expenses($filterdata=NULL){
        $gymid=$this->session->userdata('userid');
        $tablename="tbl_expenses_details_".$gymid;
        if($filterdata==NULL){
            $comparisonstartdate=date('Y-m-1');
            $comparisonenddate=date('Y-m-30');
        }
        else{
            $comparisonstartdate=$filterdata['start_date'];
            $comparisonenddate=$filterdata['end_date'];
        }
        $query=$this->db->where('`expense_date` BETWEEN "'. $comparisonstartdate. '" AND "'. $comparisonenddate.'"')->get($tablename);
        $result=$query->result_array();
        return $result;
    }
    public function get_balancesheet_totals($filterdata=NULL){
        $gymid=$this->session->userdata('userid');
        $tablename="tbl_expenses_".$gymid;
        if($filterdata==NULL){
            $comparisondate=date('Y-m-1');
        }
        else{
            $comparisondate=$filterdata['date'];
        }
        $query = $this->db->where('month_date', $comparisondate)->get($tablename);
        $result=$query->result_array();
        return $result;
    }
    public function get_all_expenses($id){
        $gymid=$this->session->userdata('userid');
        $tablename="tbl_expenses_details_".$gymid;
        $this->db->where('id', $id);
        $query=$this->db->get($tablename);
        return $query->result_array();
    }
    public function update_expenses($image = false){
        $this->load->helper('url');
        $data = array();
        $gymid=$this->session->userdata('userid');
        $tablename="tbl_expenses_details_".$gymid;
        $expenses=array();
        for($i=0;$i<$this->input->post('numberofpairs');$i++){
             $expenses[]=array(
                 'expense_title' => $this->input->post('expense_title'.$i) ,
                 'expense_amount' => $this->input->post('expense_amount'.$i)
             );
        }
        $data['expenses']=serialize($expenses);
        $this->db->where('id', $this->input->post('id'));
        $this->db->update($tablename, $data);
        if($this->updateexpensetotal(strtotime($this->input->post('expense_date')))){
            return true;
        }
    }
    public function delete_expense($id = NULL,$expensetitle=NULL,$expenseamount=NULL,$date=NULL){
        $gymid=$this->session->userdata('userid');
        $tablename="tbl_expenses_details_".$gymid;
        $this->db->where('expense_date', date('Y-m-d',$date));
        $query=$this->db->get($tablename);
        $result=$query->result_array();
        $expenseupdate=array();
        $data=array();
        if(!empty($result)){
            $expenses=unserialize($result[0]['expenses']);
            foreach($expenses as $expense){
                if($expense['expense_title']!=$expensetitle && $expense['expense_amount']!=$expenseamount){
                    $expenseupdate[]=$expense;
                }
            }
        }
        $data['expenses']=serialize($expenseupdate);
        $this->db->where('id', $id);
        $this->db->update($tablename, $data);
        if($this->updateexpensetotal($date)){
            return true;
        }
    }
    public function updateexpensetotal($date=NULL){
       $gymid=$this->session->userdata('userid');
        $tablename="tbl_expenses_details_".$gymid;
        $comparisonstartdate=date('Y-m-1',$date);
        $comparisonenddate=date('Y-m-30',$date);
        $query=$this->db->where('`expense_date` BETWEEN "'. $comparisonstartdate. '" AND "'. $comparisonenddate.'"')->get($tablename);
        $result=$query->result_array();
        $totalexpense=0;
        if(!empty($result)){
            $expenses=unserialize($result[0]['expenses']);
            for($i=0;$i<sizeof($expenses);$i++){
                $totalexpense=$totalexpense+$expenses[$i]['expense_amount'];
            }
            $data['total_expence']=$totalexpense;
            $tablenametwo="tbl_expenses_".$gymid;
            $this->db->where('month_date', $comparisonstartdate);
        return $this->db->update($tablenametwo, $data);
        }
    }
    public function GetMemberDetailById($id=NULL){
        $this->db->where('id', $id);
        $query=$this->db->get('members');
        return $query->result_array();
    }
}
?>