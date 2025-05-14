<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use setasign\Fpdi\PdfParser\StreamReader;
class Services extends CI_Controller {


	public function fetch_cities()
	{

		$stateID = $this->input->get('stateID');
		if ($stateID == null) {
				$q = $this->db->select('cities.*, states.name as StateName ,countries.name as CountryName,')
				->join('states', ' states.id = cities.state_id', 'left')
				->join('countries', ' countries.id = cities.country_id', 'left')
				->group_by('cities.id')
				->order_by('cities.name', 'asc')
				->get('cities');	
		} else {

			$q = $this->db->select('cities.*, states.name as StateName ,countries.name as CountryName,')
			->where('state_id',$stateID)
			->join('states', ' states.id = cities.state_id', 'left')
			->join('countries', ' countries.id = cities.country_id', 'left')
			->group_by('cities.id')
			->order_by('cities.name', 'asc')
			->get('cities');	
		}
		$response = array();
		if($q->num_rows() > 0) {
			$response['pageNumber'] = 1;
			$response['pageSize'] = 20;
			$response['total'] = $q->num_rows();
			$response['data'] = $q->result();
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		} else {
			$response['success'] = false;
			$response['message'] = 'No City Found.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
	}

	public function fetch_State()
	{

		$countryID = $this->input->get('countryID');
		if ($countryID == null) {
		$q = $this->db->select('states.*, countries.name as CompanyName')
		->join('countries', ' countries.id = states.country_id', 'left')
		->group_by('states.id')
		->order_by('states.name', 'asc')
		->get('states');	
		} else {

			$q = $this->db->select('states.*, countries.name as CompanyName')
			->where('country_id',$countryID)
			->join('countries', ' countries.id = states.country_id', 'left')
			->group_by('states.id')
			->order_by('states.name', 'asc')
			->get('states');	
		}
		$response = array();
		if($q->num_rows() > 0) {
			$response['pageNumber'] = 1;
			$response['pageSize'] = 20;
			$response['total'] = $q->num_rows();
			$response['data'] = $q->result();
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		} else {
			$response['success'] = false;
			$response['message'] = 'No State Found.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
	}
	public function fetch_Country()
	{
		$q = $this->db->select('countries.*')
		->order_by('countries.name', 'asc')
		->get('countries');	
		$response = array();
		if($q->num_rows() > 0) {
			$response['pageNumber'] = 1;
			$response['pageSize'] = 20;
			$response['total'] = $q->num_rows();
			$response['data'] = $q->result();
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		} else {
			$response['success'] = false;
			$response['message'] = 'No Country Found.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
	}

	public function fetch_Books()
	{
		$bookID = $this->input->get('bookID');
		if ($bookID == null || $bookID == 0) {
		$q = $this->db->select('Books.*')
			->get('Books');
		} else {
		$q = $this->db->select('Books.*')
			->where('id', $bookID)
			->get('Books');
		}
		$response = array();
		if($q->num_rows() > 0) {
			$response['pageNumber'] = 1;
			$response['pageSize'] = 20;
			$response['total'] = $q->num_rows();
			$response['data'] = $q->result();
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		} else {
			$response['success'] = false;
			$response['message'] = 'No City Found.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
	}

	public function add_Book() {
		$Title = $this->input->get('Title');
		$Thumbnail = $this->input->get('Thumbnail');
		$ViewUrl = $this->input->get('ViewUrl');
		$DownloadUrl = $this->input->get('DownloadUrl');
		$YearId = $this->input->get('YearId');
		$Sequence = $this->input->get('Sequence');

		if ($Title == null) {
			$response['success'] = false;
			$response['message'] = 'Add Book Title.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
		if ($Thumbnail == null) {
			$response['success'] = false;
			$response['message'] = 'Add Book Thumbnail.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
		if ($ViewUrl == null) {
			$response['success'] = false;
			$response['message'] = 'Add Book ViewUrl.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
		if ($DownloadUrl == null) {
			$response['success'] = false;
			$response['message'] = 'Add Book DownloadUrl.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
		if ($YearId == null) {
			$response['success'] = false;
			$response['message'] = 'Add Book YearId.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}

		
			$q = $this->db->insert('Books', array('Title' => $Title,'Thumbnail' => $Thumbnail,'ViewUrl' => $ViewUrl,'DownloadUrl' => $DownloadUrl, 'YearId' => $YearId,'Status' => 1, 'Sequence' => $Sequence, 'CreatedOn' => date('Y-m-d H:i:s')));
		if($q) {
			$response['success'] = true;
			$response['message'] = 'Book Successfully Added';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		} else {
			$response['success'] = false;
			$response['message'] = 'Something went wrong';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
	}

	public function update_Book() {
		$bookID = $this->input->get('bookID');
		$Title = $this->input->get('Title');
		$Thumbnail = $this->input->get('Thumbnail');
		$ViewUrl = $this->input->get('ViewUrl');
		$DownloadUrl = $this->input->get('DownloadUrl');
		$YearId = $this->input->get('YearId');
		$Sequence = $this->input->get('Sequence');

		if ($Title == null) {
			$response['success'] = false;
			$response['message'] = 'Add Book Title.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
		if ($Thumbnail == null) {
			$response['success'] = false;
			$response['message'] = 'Add Book Thumbnail.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
		if ($ViewUrl == null) {
			$response['success'] = false;
			$response['message'] = 'Add Book ViewUrl.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
		if ($DownloadUrl == null) {
			$response['success'] = false;
			$response['message'] = 'Add Book DownloadUrl.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
		if ($YearId == null) {
			$response['success'] = false;
			$response['message'] = 'Add Book YearId.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}

		$q = $this->db->where('id', $bookID)
			->update('Books', ['Title' => $Title,'Thumbnail' => $Thumbnail,'ViewUrl' => $ViewUrl,'DownloadUrl' => $DownloadUrl, 'YearId' => $YearId,'Status' => 1,'Sequence'=>$Sequence, 'UpdatedOn' => date('Y-m-d H:i:s')]);
		
		if($q) {
			$response['success'] = true;
			$response['message'] = 'Book Successfully Updated';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		} else {
			$response['success'] = false;
			$response['message'] = 'Something went wrong';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
	}

	public function fetch_Temple()
	{
		$stateID = $this->input->get('stateID');
		if ($stateID == null) {
			$q = $this->db->select('Temples.*, states.name as StateName ,countries.name as CountryName,')
				->join('states', ' states.id = Temples.StateId', 'left')
				->join('countries', ' countries.id = states.country_id', 'left')
				->group_by('Temples.id')
				->get('Temples');
		} else {
			$q = $this->db->select('Temples.*, states.name as StateName ,countries.name as CountryName,')
				->where('StateId', $stateID)
				->join('states', ' states.id = Temples.StateId', 'left')
				->join('countries', ' countries.id = states.country_id', 'left')
				->group_by('Temples.id')
				->get('Temples');
		}
		$response = array();
		if($q->num_rows() > 0) {
			$response['pageNumber'] = 1;
			$response['pageSize'] = 20;
			$response['total'] = $q->num_rows();
			$response['data'] = $q->result();
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		} else {
			$response['success'] = false;
			$response['message'] = 'No Temples Found.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
	}

	public function add_Temple()
	{
		$stateID = $this->input->get('stateID');
		$templeName = $this->input->get('templeName');
		if ($stateID == null) {
			$response['success'] = false;
			$response['message'] = 'Add Temple State.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
		if ($templeName == null) {
			$response['success'] = false;
			$response['message'] = 'Add Temple Name.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
		$q = $this->db->insert('Temples', array('TempleName' => $templeName,'StateId' => $stateID,'Status' => 1, 'CreatedOn' => date('Y-m-d H:i:s'), 'UpdatedOn' => date('Y-m-d H:i:s')));
		if($q) {
			$response['success'] = true;
			$response['message'] = 'Temple Successfully added';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		} else {
			$response['success'] = false;
			$response['message'] = 'No Temples Found.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
	}
	
	public function add_Offering()
	{

		if(empty($_FILES['OfferingFile']['name']) || $_FILES['OfferingFile']['name'] == '') {
			$response['success'] = false;
			$response['message'] = 'Offering Files is Missing.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
		$UserId = $this->input->get('UserId');
		$YearId = $this->input->get('YearId');
		$TempleId = $this->input->get('TempleId');
		$InitiationType = $this->input->get('InitiationType');
		$InitiationYear = $this->input->get('InitiationYear');
		$Gender = $this->input->get('Gender');
		$Country = $this->input->get('Country');
		$State = $this->input->get('State');
		$City = $this->input->get('City');
		$TempleName = $this->input->get('TempleName');
		$OfferingType = $this->input->get('OfferingType');
		if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/Offering')) {
			mkdir($_SERVER['DOCUMENT_ROOT'].'/Offering');
			if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/Offering/'.$Country )) {
				mkdir($_SERVER['DOCUMENT_ROOT'].'/Offering/'.$Country);
				if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/Offering/'.$Country.'/'.$State )) {
					mkdir($_SERVER['DOCUMENT_ROOT'].'/Offering/'.$Country.'/'.$State );
					if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/Offering/'.$Country.'/'.$State.'/'.$City)) {
						mkdir($_SERVER['DOCUMENT_ROOT'].'/Offering/'.$Country.'/'.$State.'/'.$City);
					}
				}
			}
		} else {
			if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/Offering/'.$Country )) {
				mkdir($_SERVER['DOCUMENT_ROOT'].'/Offering/'.$Country);
				if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/Offering/'.$Country.'/'.$State )) {
					mkdir($_SERVER['DOCUMENT_ROOT'].'/Offering/'.$Country.'/'.$State );
					if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/Offering/'.$Country.'/'.$State.'/'.$City)) {
						mkdir($_SERVER['DOCUMENT_ROOT'].'/Offering/'.$Country.'/'.$State.'/'.$City);
					}
				}
			} else {
				if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/Offering/'.$Country.'/'.$State )) {
					mkdir($_SERVER['DOCUMENT_ROOT'].'/Offering/'.$Country.'/'.$State );
					if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/Offering/'.$Country.'/'.$State.'/'.$City)) {
						mkdir($_SERVER['DOCUMENT_ROOT'].'/Offering/'.$Country.'/'.$State.'/'.$City);
					}
				} else {
					if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/Offering/'.$Country.'/'.$State.'/'.$City)) {
						mkdir($_SERVER['DOCUMENT_ROOT'].'/Offering/'.$Country.'/'.$State.'/'.$City);
					}
				}
			}
		}


		$fileName = basename($_FILES['OfferingFile']['name']);
    	$OfferingFile = $_SERVER['DOCUMENT_ROOT'].'/Offering/'.$Country.'/'.$State.'/'.$City.'/'.$fileName;
		if ($UserId == null) {
			$response['success'] = false;
			$response['message'] = 'Add User UserId.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
		if ($YearId == null) {
			$response['success'] = false;
			$response['message'] = 'Add User YearId.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
		if ($TempleId == null) {
			$response['success'] = false;
			$response['message'] = 'Add User TempleId.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
		if ($InitiationType == null) {
			$response['success'] = false;
			$response['message'] = 'Add User InitiationType.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
		if ($InitiationYear == null) {
			$response['success'] = false;
			$response['message'] = 'Add User InitiationYear.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
		if ($Gender == null) {
			$response['success'] = false;
			$response['message'] = 'Add User Gender.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
		if ($Country == null) {
			$response['success'] = false;
			$response['message'] = 'Add User Country.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
		if ($State == null) {
			$response['success'] = false;
			$response['message'] = 'Add User State.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
		if ($City == null) {
			$response['success'] = false;
			$response['message'] = 'Add User City.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
		if ($TempleName == null) {
			$response['success'] = false;
			$response['message'] = 'Add User TempleName.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
		if ($OfferingType == null) {
			$response['success'] = false;
			$response['message'] = 'Add User OfferingType.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}

		$userCheck = $this->db->select('Users.*')
		->where('id', $UserId)
		->group_by('Users.id')
		->get('Users');

		$q = $this->db->insert('Offerings', array('UserId' => $UserId,'FirstName' => $userCheck->row()->FirstName,'LastName' => $userCheck->row()->LastName, 'YearId' => $YearId, 'TempleId' => $TempleId, 'OfferingFile' => $OfferingFile, 'InitiationType' => $InitiationType, 'InitiationYear' => $InitiationYear, 'Gender' => $Gender, 'Country' => $Country, 'State' => $State, 'City' => $City, 'TempleName' => $TempleName, 'OfferingType' => $OfferingType, 'CreatedOn' => date('Y-m-d H:i:s')));
		
		if(move_uploaded_file($_FILES['OfferingFile']['tmp_name'], $OfferingFile)) {
			$response['success'] = true;
			$response['message'] = 'Offering Successfully Added';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		} else {
			$response['success'] = false;
			$response['message'] = 'Something went wrong';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
	}

	public function add_User()
	{
		$FirstName = $this->input->get('FirstName');
		$LastName = $this->input->get('LastName');
		$Gender = $this->input->get('Gender');
		$Email = $this->input->get('Email');
		$PhoneNumber = $this->input->get('PhoneNumber');
		$CountryId = $this->input->get('CountryId');
		$CityId = $this->input->get('CityId');
		$stateID = $this->input->get('StateId');

		if ($FirstName == null) {
			$response['success'] = false;
			$response['message'] = 'Add User FirstName.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
		if ($LastName == null) {
			$response['success'] = false;
			$response['message'] = 'Add User LastName.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
		if ($Gender == null) {
			$response['success'] = false;
			$response['message'] = 'Add User Gender.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
		if ($PhoneNumber == null) {
			$response['success'] = false;
			$response['message'] = 'Add User PhoneNumber.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
		if ($Email == null) {
			$response['success'] = false;
			$response['message'] = 'Add User Email.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}if ($CountryId == null) {
			$response['success'] = false;
			$response['message'] = 'Add User CountryId.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
		if ($CityId == null) {
			$response['success'] = false;
			$response['message'] = 'Add User CityId.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
		if ($stateID == null) {
			$response['success'] = false;
			$response['message'] = 'Add User stateID.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}

		$userCheck = $this->db->select('Users.id')
		->where('UPPER(Email)', strtoupper($Email))
		->group_by('Users.id')
		->get('Users');
		if($userCheck->num_rows() == 0) {
			$q = $this->db->insert('Users', array('FirstName' => $FirstName,'LastName' => $LastName,'Gender' => $Gender,'PhoneNumber' => $PhoneNumber, 'Email' => $Email,'CountryId' => $CountryId,'CityId' => $CityId,'stateID' => $stateID, 'CreatedOn' => date('Y-m-d H:i:s')));
		} else {
			$q = $this->db->where('UPPER(Email)', strtoupper($Email))
			->update('Users', ['FirstName' => $FirstName,'LastName' => $LastName,'Gender' => $Gender,'PhoneNumber' => $PhoneNumber, 'Email' => $Email,'CountryId' => $CountryId,'CityId' => $CityId,'stateID' => $stateID, 'CreatedOn' => date('Y-m-d H:i:s')]);
		}
		if($q) {
			$response['success'] = true;
			if($userCheck->num_rows() == 0) {
				$response['userID'] = $this->db->insert_id();
			$response['message'] = 'User Successfully Added';
			} else {
				$response['userID'] = $userCheck>row()->id;
				$response['message'] = 'User Successfully Updated';
			}
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		} else {
			$response['success'] = false;
			$response['message'] = 'Something went wrong';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
	}

	public function fetch_User()
	{
		$Email = $this->input->get('email');
		if ($Email == null) {
			$response['success'] = false;
			$response['message'] = 'Add User Email.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
		
		$q = $this->db->select('Users.*')
		->where('UPPER(Email)', strtoupper($Email))
		->group_by('Users.id')
		->get('Users');
		if($q->num_rows() > 0) {
			$response['pageNumber'] = 1;
			$response['pageSize'] = 20;
			$response['total'] = $q->num_rows();
			$response['data'] = $q->result();
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		} else {
			$response['success'] = false;
			$response['message'] = 'No user Found.';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
	}

	public function admin_Login() {
		$username = $this->input->get('username');
		$password = $this->input->get('password');

		if ($username == 'admin@gmail.com' && $password == 'Admin@1006') {
			$response['success'] = true;
			$response['message'] = 'Admin Login Successfully';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		} else {
			$response['success'] = false;
			$response['message'] = 'Admin Login Failed due to Username or Password Wrong';
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response);exit();
		}
	}


	public function export_Offering() {
		$zip = new ZipArchive();
 		$filename = "./myzipfile.zip";

 		if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
  			exit("cannot open <$filename>\n");
 		}
		$dir = $_SERVER['DOCUMENT_ROOT'].'/Offering/';
 		createZip($zip,$dir);
 		$zip->close();

	}

	function createZip($zip,$dir){
		if (is_dir($dir)){
		 	if ($dh = opendir($dir)){
		  		while (($file = readdir($dh)) !== false){
		   			// If file
		   			if (is_file($dir.$file)) {
						if($file != '' && $file != '.' && $file != '..'){
			 				$zip->addFile($dir.$file);
						}
		   			}else{
						// If directory
						if(is_dir($dir.$file) ){
							if($file != '' && $file != '.' && $file != '..'){
			  					// Add empty directory
			  					$zip->addEmptyDir($dir.$file);
			  					$folder = $dir.$file.'/';
			  					// Read data of the folder
			  					createZip($zip,$folder);
			 				}
						}
		   			}
		  		}
		  		closedir($dh);
		 	}
		}
	}
}
