<?php
class ModelFarmerApproval extends Model {
	
	public function getFarmers() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "farmer where oc_f_otp_status=1");

		return $query->rows;
	}

}
