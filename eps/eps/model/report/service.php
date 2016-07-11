<?php
class ModelReportService extends Model {
	// Sales
	public function getTotalSales($data = array()) {
		$sql = "SELECT SUM(total) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id > '0'";

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	// Engagements
	public function getTotalBookingByDay() {


		$order_data = array();

		for ($i = 0; $i < 24; $i++) {
			$order_data[$i] = array(
				'hour'  => $i,
				'total' => 0
			);
		}

		$sql="SELECT count(*) as total,HOUR(DateService) as hour FROM `epspe_engagement` 	WHERE DATE(DateService) = DATE(NOW()) GROUP BY HOUR(DateService) ORDER BY DateService ASC";
		$query = $this->db->query($sql);
		//$query = $this->db->query("SELECT COUNT(*) AS total, HOUR(date_added) AS hour FROM `" . DB_PREFIX . "order` WHERE order_status_id IN(" . implode(",", $implode) . ") AND DATE(date_added) = DATE(NOW()) GROUP BY HOUR(date_added) ORDER BY date_added ASC");

		foreach ($query->rows as $result) {
			$order_data[$result['hour']] = array(
				'hour'  => $result['hour'],
				'total' => $result['total']
			);
		}


		return $order_data;
	}

	public function getTotalOpenBookingByDay() {
		$booking_data = array();

		for ($i = 0; $i < 24; $i++) {
			$order_data[$i] = array(
					'hour'  => $i,
					'total' => 0
			);
		}

		$sql = "SELECT count(*) as total,HOUR(DateService) as hour FROM `epspe_engagement` WHERE Type ='Strategic' and DateService = DATE(NOW()) GROUP BY HOUR(DateService) ORDER BY DateService ASC";

		// AND DATE(bkdiscts) = DATE(NOW())
		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$booking_data[$result['hour']] = array(
					'hour'  => $result['hour'],
					'total' => $result['total']
			);
		}
		$this->session->data['chart_test']=$booking_data;
		return $booking_data;
	}

	public function getTotalReceivedBookingByDay() {
		$booking_r_data = array();

		for ($i = 0; $i < 24; $i++) {
			$booking_r_data[$i] = array(
					'hour'  => $i,
					'total' => 0
			);
		}
  	$sql = "SELECT count(*) as total,HOUR(DateService) as hour FROM `epspe_engagement` WHERE Type ='Packaged' and DateService = DATE(NOW()) GROUP BY HOUR(DateService) ORDER BY DateService ASC";
		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$booking_r_data[$result['hour']] = array(
					'hour'  => $result['hour'],
					'total' => $result['total']
			);
		}

		return $booking_r_data;
	}

	public function getTotalBookingByWeek() {


		$order_data = array();

		$date_start = strtotime('-' . date('w') . ' days');

		for ($i = 0; $i < 7; $i++) {
			$date = date('Y-m-d', $date_start + ($i * 86400));

			$order_data[date('w', strtotime($date))] = array(
				'day'   => date('D', strtotime($date)),
				'total' => 0
			);
		}

		$sql="SELECT COUNT(*) AS total, DateService as date_added FROM `" . DB_PREFIX_APP . "engagement` WHERE monthname(curdate()) = monthname(DateService) and (YEAR(curdate()) = (YEAR(DateService))) and week(curdate()) = week(DateService) group by DAYNAME(DateService)";

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$order_data[date('w', strtotime($result['date_added']))] = array(
				'day'   => date('D', strtotime($result['date_added'])),
				'total' => $result['total']
			);
		}
		$this->session->data['test_report_booking'] = $order_data;
		return $order_data;
	}

	public function getTotalOpenBookingByWeek(){
		$booking_r_data = array();

		$date_start = strtotime('-' . date('w') . ' days');

		for ($i = 0; $i < 7; $i++) {
			$date = date('Y-m-d', $date_start + ($i * 86400));

			$booking_r_data[date('w', strtotime($date))] = array(
					'day'   => date('D', strtotime($date)),
					'total' => 0
			);
		}

		$sql= "SELECT COUNT(*) AS total, DateService as date_added,DAYNAME(DateService) as day
				FROM `" . DB_PREFIX_APP . "engagement` WHERE Type IN('Packaged') AND week(DateService) = week(now())
				GROUP BY DAYNAME(DateService) order by DateService asc";

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$booking_r_data[date('w', strtotime($result['date_added']))] = array(
					'day'   => date('D', strtotime($result['date_added'])),
					'total' => $result['total']
			);
		}

		return $booking_r_data;
	}

	public function getTotalReceivedBookingByWeek(){
		$booking_r_data = array();

		$date_start = strtotime('-' . date('w') . ' days');

		for ($i = 0; $i < 7; $i++) {
			$date = date('Y-m-d', $date_start + ($i * 86400));

			$booking_r_data[date('w', strtotime($date))] = array(
					'day'   => date('D', strtotime($date)),
					'total' => 0
			);
		}
		$sql= "SELECT COUNT(*) AS total, DateService as date_added,DAYNAME(DateService) as day
				FROM `" . DB_PREFIX_APP . "engagement` WHERE Type IN('Strategic') AND week(DateService) = week(now())
				GROUP BY DAYNAME(DateService) order by DateService asc";

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$booking_r_data[date('w', strtotime($result['date_added']))] = array(
					'day'   => date('D', strtotime($result['date_added'])),
					'total' => $result['total']
			);
		}

		return $booking_r_data;
	}

	public function getTotalBookingByMonth() {


		$order_data = array();

		for ($i = 1; $i <= date('t'); $i++) {
			$date = date('Y') . '-' . date('m') . '-' . $i;

			$order_data[date('j', strtotime($date))] = array(
				'day'   => date('d', strtotime($date)),
				'total' => 0
			);
		}

		$sql="SELECT COUNT(*) AS total, DateService as date_added FROM `epspe_engagement` WHERE monthname(curdate()) >=  monthname(DateService) and YEAR(DateService) = YEAR(curdate()) GROUP BY DATE(DateService)";

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$order_data[date('j', strtotime($result['date_added']))] = array(
				'day'   => date('d', strtotime($result['date_added'])),
				'total' => $result['total']
			);
		}

		return $order_data;
	}

	public function getTotalReceivedBookingByMonth(){
		$booking_r_data = array();

		for ($i = 1; $i <= date('t'); $i++) {
			$date = date('Y') . '-' . date('m') . '-' . $i;

			$booking_r_data[date('j', strtotime($date))] = array(
					'day'   => date('d', strtotime($date)),
					'total' => 0
			);
		}
		$sql="SELECT COUNT(*) AS total, DateService as date_added FROM `" . DB_PREFIX_APP . "engagement` WHERE Type IN('Strategic') AND Month(DateService) = Month(now())	GROUP BY DATE(DateService) order by DateService asc";

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$booking_r_data[date('j', strtotime($result['date_added']))] = array(
					'day'   => date('d', strtotime($result['date_added'])),
					'total' => $result['total']
			);
		}

		return $booking_r_data;
	}

	public function getTotalOpenBookingByMonth(){
		$booking_r_data = array();

		for ($i = 1; $i <= date('t'); $i++) {
			$date = date('Y') . '-' . date('m') . '-' . $i;

			$booking_r_data[date('j', strtotime($date))] = array(
					'day'   => date('d', strtotime($date)),
					'total' => 0
			);
		}

		$sql="SELECT COUNT(*) AS total, DateService as date_added FROM `" . DB_PREFIX_APP . "engagement` WHERE Type IN('Packaged') AND Month(DateService) = Month(now())	GROUP BY DATE(DateService) order by DateService asc";

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$booking_r_data[date('j', strtotime($result['date_added']))] = array(
					'day'   => date('d', strtotime($result['date_added'])),
					'total' => $result['total']
			);
		}

		return $booking_r_data;
	}


	public function getTotalOrdersByYear() {


		$order_data = array();

		for ($i = 1; $i <= 12; $i++) {
			$order_data[$i] = array(
				'month' => date('M', mktime(0, 0, 0, $i)),
				'total' => 0
			);
		}

			$sql = "select count(*) as total,DateService as date_added,monthname(DateService) from `" . DB_PREFIX_APP . "engagement` where YEAR(DateService) = YEAR(NOW()) GROUP BY MONTH(DateService)";

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$order_data[date('n', strtotime($result['date_added']))] = array(
				'month' => date('M', strtotime($result['date_added'])),
				'total' => $result['total']
			);
		}

		return $order_data;
	}

	public function getTotalOpenBookingByYear() {


		$order_data = array();

		for ($i = 1; $i <= 12; $i++) {
			$order_data[$i] = array(
					'month' => date('M', mktime(0, 0, 0, $i)),
					'total' => 0
			);
		}

		$sql = "select count(*) as total,DateService as date_added,monthname(DateService) from `" . DB_PREFIX_APP . "engagement` where Type = 'Packaged'
			AND YEAR(DateService) = YEAR(NOW()) GROUP BY MONTH(DateService)";

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$order_data[date('n', strtotime($result['date_added']))] = array(
					'month' => date('M', strtotime($result['date_added'])),
					'total' => $result['total']
			);
		}

		return $order_data;
	}

	public function getTotalReceivedBookingByYear() {
	

		$order_data = array();

		for ($i = 1; $i <= 12; $i++) {
			$order_data[$i] = array(
					'month' => date('M', mktime(0, 0, 0, $i)),
					'total' => 0
			);
		}

		$sql = "select count(*) as total,DateService as date_added,monthname(DateService) from `" . DB_PREFIX_APP . "engagement` where Type = 'Strategic'
		AND YEAR(DateService) = YEAR(NOW()) GROUP BY MONTH(DateService)";

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$order_data[date('n', strtotime($result['date_added']))] = array(
					'month' => date('M', strtotime($result['date_added'])),
					'total' => $result['total']
			);
		}

		return $order_data;
	}

	public function getOrders($data = array()) {
		$sql = "SELECT MIN(o.date_added) AS date_start, MAX(o.date_added) AS date_end, COUNT(*) AS `orders`, (SELECT SUM(op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id GROUP BY op.order_id) AS products, (SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'tax' GROUP BY ot.order_id) AS tax, SUM(o.total) AS `total` FROM `" . DB_PREFIX . "order` o";

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " WHERE o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " WHERE o.order_status_id > '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_group'])) {
			$group = $data['filter_group'];
		} else {
			$group = 'week';
		}

		switch($group) {
			case 'day';
				$sql .= " GROUP BY YEAR(o.date_added), MONTH(o.date_added), DAY(o.date_added)";
				break;
			default:
			case 'week':
				$sql .= " GROUP BY YEAR(o.date_added), WEEK(o.date_added)";
				break;
			case 'month':
				$sql .= " GROUP BY YEAR(o.date_added), MONTH(o.date_added)";
				break;
			case 'year':
				$sql .= " GROUP BY YEAR(o.date_added)";
				break;
		}

		$sql .= " ORDER BY o.date_added DESC";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalOrders($data = array()) {
		if (!empty($data['filter_group'])) {
			$group = $data['filter_group'];
		} else {
			$group = 'week';
		}

		switch($group) {
			case 'day';
				$sql = "SELECT COUNT(DISTINCT YEAR(date_added), MONTH(date_added), DAY(date_added)) AS total FROM `" . DB_PREFIX . "order`";
				break;
			default:
			case 'week':
				$sql = "SELECT COUNT(DISTINCT YEAR(date_added), WEEK(date_added)) AS total FROM `" . DB_PREFIX . "order`";
				break;
			case 'month':
				$sql = "SELECT COUNT(DISTINCT YEAR(date_added), MONTH(date_added)) AS total FROM `" . DB_PREFIX . "order`";
				break;
			case 'year':
				$sql = "SELECT COUNT(DISTINCT YEAR(date_added)) AS total FROM `" . DB_PREFIX . "order`";
				break;
		}

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " WHERE order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " WHERE order_status_id > '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTaxes($data = array()) {
		$sql = "SELECT MIN(o.date_added) AS date_start, MAX(o.date_added) AS date_end, ot.title, SUM(ot.value) AS total, COUNT(o.order_id) AS `orders` FROM `" . DB_PREFIX . "order` o LEFT JOIN `" . DB_PREFIX . "order_total` ot ON (ot.order_id = o.order_id) WHERE ot.code = 'tax'";

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " AND o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " AND o.order_status_id > '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_group'])) {
			$group = $data['filter_group'];
		} else {
			$group = 'week';
		}

		switch($group) {
			case 'day';
				$sql .= " GROUP BY YEAR(o.date_added), MONTH(o.date_added), DAY(o.date_added), ot.title";
				break;
			default:
			case 'week':
				$sql .= " GROUP BY YEAR(o.date_added), WEEK(o.date_added), ot.title";
				break;
			case 'month':
				$sql .= " GROUP BY YEAR(o.date_added), MONTH(o.date_added), ot.title";
				break;
			case 'year':
				$sql .= " GROUP BY YEAR(o.date_added), ot.title";
				break;
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalTaxes($data = array()) {
		if (!empty($data['filter_group'])) {
			$group = $data['filter_group'];
		} else {
			$group = 'week';
		}

		switch($group) {
			case 'day';
				$sql = "SELECT COUNT(DISTINCT YEAR(o.date_added), MONTH(o.date_added), DAY(o.date_added), ot.title) AS total FROM `" . DB_PREFIX . "order` o";
				break;
			default:
			case 'week':
				$sql = "SELECT COUNT(DISTINCT YEAR(o.date_added), WEEK(o.date_added), ot.title) AS total FROM `" . DB_PREFIX . "order` o";
				break;
			case 'month':
				$sql = "SELECT COUNT(DISTINCT YEAR(o.date_added), MONTH(o.date_added), ot.title) AS total FROM `" . DB_PREFIX . "order` o";
				break;
			case 'year':
				$sql = "SELECT COUNT(DISTINCT YEAR(o.date_added), ot.title) AS total FROM `" . DB_PREFIX . "order` o";
				break;
		}

		$sql .= " LEFT JOIN `" . DB_PREFIX . "order_total` ot ON (o.order_id = ot.order_id) WHERE ot.code = 'tax'";

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " AND o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " AND o.order_status_id > '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getShipping($data = array()) {
		$sql = "SELECT MIN(o.date_added) AS date_start, MAX(o.date_added) AS date_end, ot.title, SUM(ot.value) AS total, COUNT(o.order_id) AS `orders` FROM `" . DB_PREFIX . "order` o LEFT JOIN `" . DB_PREFIX . "order_total` ot ON (o.order_id = ot.order_id) WHERE ot.code = 'shipping'";

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " AND o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " AND o.order_status_id > '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		if (!empty($data['filter_group'])) {
			$group = $data['filter_group'];
		} else {
			$group = 'week';
		}

		switch($group) {
			case 'day';
				$sql .= " GROUP BY YEAR(o.date_added), MONTH(o.date_added), DAY(o.date_added), ot.title";
				break;
			default:
			case 'week':
				$sql .= " GROUP BY YEAR(o.date_added), WEEK(o.date_added), ot.title";
				break;
			case 'month':
				$sql .= " GROUP BY YEAR(o.date_added), MONTH(o.date_added), ot.title";
				break;
			case 'year':
				$sql .= " GROUP BY YEAR(o.date_added), ot.title";
				break;
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalShipping($data = array()) {
		if (!empty($data['filter_group'])) {
			$group = $data['filter_group'];
		} else {
			$group = 'week';
		}

		switch($group) {
			case 'day';
				$sql = "SELECT COUNT(DISTINCT YEAR(o.date_added), MONTH(o.date_added), DAY(o.date_added), ot.title) AS total FROM `" . DB_PREFIX . "order` o";
				break;
			default:
			case 'week':
				$sql = "SELECT COUNT(DISTINCT YEAR(o.date_added), WEEK(o.date_added), ot.title) AS total FROM `" . DB_PREFIX . "order` o";
				break;
			case 'month':
				$sql = "SELECT COUNT(DISTINCT YEAR(o.date_added), MONTH(o.date_added), ot.title) AS total FROM `" . DB_PREFIX . "order` o";
				break;
			case 'year':
				$sql = "SELECT COUNT(DISTINCT YEAR(o.date_added), ot.title) AS total FROM `" . DB_PREFIX . "order` o";
				break;
		}

		$sql .= " LEFT JOIN `" . DB_PREFIX . "order_total` ot ON (o.order_id = ot.order_id) WHERE ot.code = 'shipping'";

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " AND order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " AND order_status_id > '0'";
		}

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}


}
