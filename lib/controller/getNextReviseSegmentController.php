<?php
include_once INIT::$MODEL_ROOT . "/queries.php";

class getNextReviseSegmentController extends ajaxController {

	private $id_segment;
	private $id_job;
	private $password;

	public function __construct() {

		parent::__construct();

		$filterArgs = array(
				'id_segment' => array( 'filter' => FILTER_SANITIZE_NUMBER_INT ),
				'id_job'     => array( 'filter' => FILTER_SANITIZE_NUMBER_INT ),
				'password'   => array(
						'filter' => FILTER_SANITIZE_STRING, 'flags' => FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH
				),

				//not used
				'status'     => array(
						'filter' => FILTER_SANITIZE_STRING, 'flags' => FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH
				),

		);

		$__postInput = filter_input_array( INPUT_POST, $filterArgs );

		//NOTE: This is for debug purpose only,
		//NOTE: Global $_POST Overriding from CLI Test scripts
		//$__postInput = filter_var_array( $_POST, $filterArgs );

		$this->id_segment = (int)$__postInput[ 'id_segment' ];
		$this->id_job     = (int)$__postInput[ 'id_job' ];
		$this->password   = $__postInput[ 'password' ];

	}

	public function doAction() {

		if ( empty( $this->id_segment ) ) {
			$this->result[ 'error' ][ ] = array( "code" => -1, "message" => "missing segment id" );
		}

		if ( empty( $this->id_job ) ) {
			$this->result[ 'error' ][ ] = array( "code" => -1, "message" => "missing job id" );
		}

		if ( empty( $this->password ) ) {
			$this->result[ 'error' ][ ] = array( "code" => -1, "message" => "missing job password" );
		}

		$nextSegmentId            = getNextSegment( $this->id_segment, $this->id_job, $this->password, true );
		$this->result[ 'nextId' ] = $nextSegmentId;
		$this->result[ 'code' ]   = 1;
		$this->result[ 'data' ]   = "OK";

	}


}