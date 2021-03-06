<?php

/**
 * helper functions to send database requests
 */

	// include the configs / constants for the database connection
	require_once("db.php");
	
	//open database connection
	function openConnection(){
		//Open a new connection to the MySQL server
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	
		//Output any connection error
		if ($mysqli->connect_error) {
			die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);	
		}
		return $mysqli;
	}
	
	// close database connection 
	function closeConnection($mysqli){	
		$mysqli->close();
	}
	
    
    //we define the Shoe class along with its constructor
    class Shoe{
        public $name;
        public $brand;
        public $price;
        public $blurb;
        public $traction;
        public $cushion;
        public $materials;
        public $fit;
        public $support;
        public $image;
        public $extra;
        public $tech;
        
        public function __construct($shoe_name, $shoe_brand, $shoe_price, $shoe_blurb, $shoe_traction, $shoe_cushion, $shoe_materials, $shoe_fit, $shoe_support, $shoe_image, $shoe_image_extra, $shoe_tech) {
              $this->name = $shoe_name;
              $this->brand = $shoe_brand;
              $this->price = $shoe_price;
              $this->blurb = $shoe_blurb;
              $this->traction = $shoe_traction;
              $this->cushion = $shoe_cushion;
              $this->materials = $shoe_materials;
              $this->fit = $shoe_fit;
              $this->support = $shoe_support;
              $this->image = $shoe_image;
              $this->extra = $shoe_image_extra;
              $this->tech = $shoe_tech;
        }
    }
    
    
    //get and return the shoes information from the database as an array of Shoe objects
	function getShoes($mysqli){
		
		//select the first 10 event elements from the database
		$query = "SELECT * FROM shoes";
		$results = $mysqli->query($query);

        //populate the results into an array of Event objects
        $shoeArray = array();
        
        while($row = $results->fetch_array()){
            
            $tempShoe = new Shoe($row["shoe_name"], $row["shoe_brand"], $row["shoe_price"], $row["shoe_blurb"], $row["shoe_traction"], $row["shoe_cushion"], $row["shoe_materials"], $row["shoe_fit"], $row["shoe_support"], $row["shoe_image"], $row["shoe_image_extra"], $row["shoe_tech"]);
            array_push($shoeArray, $tempShoe);
        }
        return $shoeArray;
    }
    
    //return the shoes' information from the database as a Shoe array shoes' name in an array
	function getShoesByNames($mysqli, $name_array){
        //initialize the array to return the shoes
        $shoeArray = array();
        
        foreach($name_array as $name){
            $query = "SELECT * FROM shoes WHERE shoe_name=?";
            $statement = $mysqli->prepare($query);
            
            //bind parameters for markers where (s=string, i=integer, d=double, b=blob)
            $statement->bind_param('s',$name);
            
            //execute query
            $statement->execute();
            
            //bind result variables
            $statement->bind_result($shoe_id,$shoe_name,$shoe_brand,$shoe_price,$shoe_blurb,$shoe_traction,$shoe_cushion,$shoe_materials,$shoe_fit,$shoe_support,$shoe_image,$shoe_image_extra,$shoe_tech);
            
            while($statement->fetch()){  
                $tempShoe = new Shoe($shoe_name, $shoe_brand, $shoe_price, $shoe_blurb, $shoe_traction, $shoe_cushion, $shoe_materials, $shoe_fit, $shoe_support, $shoe_image, $shoe_image_extra, $shoe_tech);
                array_push($shoeArray, $tempShoe);
            }
        }     
        return $shoeArray;
    }
    
    
    
    /** Old Ticket database functions  **/
    
    
    
    //given an EventId, return the event information from the database as an Event object
	function getEventById($mysqli, $eventId){
	
        //create the prepared statement
		$query = "SELECT * FROM events WHERE event_id=?";
		$statement = $mysqli->prepare($query);
		
		//bind parameters for markers where (s=string, i=integer, d=double, b=blob)
		$statement->bind_param('i',$eventId);
		
		//execute query
		$statement->execute();
		
		//bind result variables
		$statement->bind_result($event_id,$event_name,$event_start,$event_end,$event_blurb,$event_description,$event_details,$event_location,$event_image);
        
        while($statement->fetch()){
            //format SQL datetime into more human-friendly text
            $formattedStart = date("j M Y - g:ia", strtotime($event_start));
            $formattedEnd = date("j M Y - g:ia", strtotime($event_end));
            
            $tempEvent = new Event($event_name,$formattedStart,$formattedEnd,$event_blurb,$event_description,$event_details,$event_location, $event_image);
        }
        return $tempEvent;    
    }
    
    
    
    
    
    //given an array of Event objects, it prints their info out into the required html
    function displayEvents($eventArray){
        $counter = 1;
        
        foreach($eventArray as $element){
            
            //prints the html tags that display an Event on the Event grid
            print '<div class="col-md-4 event-frame">';
            print '<div class= "image-frame">';
            print '<img src="'.$element->image.'" alt="" class="img-responsive">';
            print '</div>';
            print '<h4>'.$element->name.'</h4>';
            print '<p class="date-time">'.$element->start.'</p>'; 
            print '<p>'.$element->blurb.'</p>'; 
            print '</div>';
            
            //ensures that each row is properly aligned even if event-frame elements vary in size
            if($counter % 3 === 0){
                print '<div class="clearfix visible-md-block"></div>';
            }
            
            $counter++;
        }
    }
    
    //given an EventId, return the tickets information from the database as a Tickets array
	function getTicketsByEventId($mysqli, $eventId){
	
        //create the prepared statement
		$query = "SELECT ticket_id, ticket_name, ticket_price FROM events_tickets WHERE event_id=?";
		$statement = $mysqli->prepare($query);
		
		//bind parameters for markers where (s=string, i=integer, d=double, b=blob)
		$statement->bind_param('i',$eventId);
		
		//execute query
		$statement->execute();
		
		//bind result variables
		$statement->bind_result($ticket_id,$ticket_name,$ticket_price);
        
        //populate the results into an array of Ticket objects
        $ticketArray = array();
        while($statement->fetch()){

            $tempTicket = new Ticket($ticket_id,$ticket_name,$ticket_price);
            array_push($ticketArray, $tempTicket);
        }
        return $ticketArray;    
    }
    
    //given an array of Ticket objects, it prints their info out into the required html
    function displayTickets($ticketArray){
        
        foreach($ticketArray as $element){  
            //prints the html tags that display a Ticket on the tickets table
            print '<tr>';
            print '<td>'.$element->name.'</td>';
            print '<td>S$'.$element->price.'</td>';
            print '<td><select class="ticket-num-select" data-ticketid='.$element->id.'>';
            print '<option>1</option>';
            print '<option>2</option>';
            print '<option>3</option>';
            print '<option>4</option>';
            print '<option>5</option>';
            print '</select></td>';
            print '</tr>';     
        }
        
        //we also print the html tags for the order button
        print '<tr>';
        print '<td></td>';
        print '<td></td>';
        print '<td><button id="order-btn" class="btn btn-green">Order Now</button></td>';
        print '</tr>'; 
       
    }

	    
    
    
    
    
    
    
    
    
    
    
    
    
    
    /** Old Spark-SMS functions **/
    
    
    
    
    
    
    
    
    
	//returns inbound msg information (inbound_from, inbound_text) in html table row
	//if $checkbox===true, we include a checkbox in each table row for subsequent record deletion
	function getInboundInfo($mysqli,$checkbox){
		$user_name = $_SESSION['user_name'];
		
		//create the prepared statement
		/**	We use a subselect where we (a) get the inbound ids associated with the user
			and then (b) get their corresponding inbound_from and inbound_text from inbound table
		**/
		$query = "SELECT inbound_id, inbound_from, inbound_text, inbound_created FROM inbound WHERE inbound_id IN 
				(SELECT inbound_id FROM inbound_users WHERE user_name=?)";
		$statement = $mysqli->prepare($query);
		
		
		//bind parameters for markers where (s=string, i=integer, d=double, b=blob)
		$statement->bind_param('s',$user_name);
		
		//execute query
		$statement->execute();
		
		//bind result variables
		$statement->bind_result($inbound_id, $inbound_from,$inbound_text,$inbound_created);
		

		//get contacts info in html table row with checkbox for delete_contacts
		if ($checkbox){
			while($statement->fetch()) {
				print '<tr>';
				print '<td><input type="checkbox" name="checkbox[]" value='.$inbound_id.' id="checkbox"></td>';
				print '<td>'.$inbound_created.'</td>';
				print '<td class="name">'.$inbound_from.'</td>';
				print '<td>'.$inbound_text.'</td>';
				print '<td>Actions go here</td>';
				print '</tr>';
			}
		}
		//get contacts info in html table row with checkbox for display_contacts
		else {
			while($statement->fetch()) {
				print '<tr>';
				print '<td>'.$inbound_created.'</td>';
				print '<td class="name">'.$inbound_from.'</td>';
				print '<td>'.$inbound_text.'</td>';
				print '<td>Actions go here</td>';
				print '</tr>';
			}  
		}
		
	}
	
	
	//returns contact information (contact_name, contact_number) in html table row
	//if $checkbox===true, we include a checkbox in each table row for subsequent record deletion
	function getContactInfo($mysqli,$checkbox){
		$user_name = $_SESSION['user_name'];
		
		//create the prepared statement
		/**	We use a subselect where we (a) get the contact ids associated with the user
			and then (b) get their corresponding contact_name and contact_number from contacts table
		**/
		$query = "SELECT contact_id, contact_name, contact_country_code, contact_number FROM contacts WHERE contact_id IN 
				(SELECT contact_id FROM contacts_users WHERE user_name=?)";
		$statement = $mysqli->prepare($query);
		
		
		//bind parameters for markers where (s=string, i=integer, d=double, b=blob)
		$statement->bind_param('s',$user_name);
		
		//execute query
		$statement->execute();
		
		//bind result variables
		$statement->bind_result($contact_id, $contact_name,$contact_country_code,$contact_number);
		

		//get contacts info in html table row with checkbox for delete_contacts
		if ($checkbox){
			while($statement->fetch()) {
				print '<tr>';
				print '<td><input type="checkbox" name="checkbox[]" value='.$contact_id.' id="checkbox"></td>';
				print '<td class="name">'.$contact_name.'</td>';
				print '<td>'.$contact_country_code." ".$contact_number.'</td>';
				print '<td>Tags go here</td>';
				print '</tr>';
			}
		}
		//get contacts info in html table row with checkbox for display_contacts
		else {
			while($statement->fetch()) {
				print '<tr>';
				print '<td class="name">'.$contact_name.'</td>';
				print '<td>'.$contact_country_code." ".$contact_number.'</td>';
				print '<td>Tags go here</td>';
				print '</tr>';
			}  
		}
		
	}
	
	//returns outbound msg information Date/Time,From,To,Campaign,SMS Text,Status in html table row
	//if $checkbox===true, we include a checkbox in each table row for subsequent record deletion
	function getOutboundInfo($mysqli,$checkbox){
		$user_name = $_SESSION['user_name'];
		
		//create the prepared statement
		/**	We use a subselect where we (a) get the outbound ids associated with the user
			and then (b) get the corresponding outbound msg infomation from outbound table
		**/
		$query = "SELECT outbound_id, outbound_created, outbound_from, outbound_to, outbound_title, outbound_text, outbound_status FROM outbound WHERE outbound_id IN 
				(SELECT outbound_id FROM outbound_users WHERE user_name=?)";
		$statement = $mysqli->prepare($query);
		
		
		//bind parameters for markers where (s=string, i=integer, d=double, b=blob)
		$statement->bind_param('s',$user_name);
		
		//execute query
		$statement->execute();
		
		//bind result variables
		$statement->bind_result($outbound_id,$outbound_created,$outbound_from,$outbound_to,$outbound_title,$outbound_text,$outbound_status);
		

		//get contacts info in html table row with checkbox for delete_contacts
		if ($checkbox){
			while($statement->fetch()) {
			print '<tr>';
			print '<td><input type="checkbox" name="checkbox[]" value='.$outbound_id.' id="checkbox"></td>';
			print '<td>'.$outbound_created.'</td>';
			print '<td>'.$outbound_from.'</td>';
			print '<td>'.$outbound_to.'</td>';
			print '<td>'.$outbound_title.'</td>';
			print '<td>'.$outbound_text.'</td>';
			print '<td>'.$outbound_status.'</td>';
			print '</tr>';
			}
		}
		//get contacts info in html table row with checkbox for display_contacts
		else {
			while($statement->fetch()) {
			print '<tr>';
			print '<td>'.$outbound_created.'</td>';
			print '<td>'.$outbound_from.'</td>';
			print '<td>'.$outbound_to.'</td>';
			print '<td>'.$outbound_title.'</td>';
			print '<td>'.$outbound_text.'</td>';
			print '<td>'.$outbound_status.'</td>';
			print '</tr>';
			}  
		}
		
		
	}
	
	//Takes in a mysqli connection and deletes the contact with $contact_id from contacts table
	//Be careful of cascade effects on related tables (contact_id is a primary key)
	function removeContactInfo($mysqli, $contact_id){
		
		//setup the prepared statement for the delete query
		$query = "DELETE FROM contacts WHERE contact_id=?";
		$statement = $mysqli->prepare($query);
		
		//bind parameters for markers where (s=string, i=integer, d=double, b=blob)
		$statement->bind_param('i',$contact_id);
		
		//execute query and print any errors that occur
		if(!$statement->execute()){
			print 'Failed to DELETE FROM (contacts table): '.$contact_id;
			return false;
		}
		return true;
	}
	//Takes in a mysqli connection and deletes the keyword with $keyword_id from keywords table
	function removeKeyword($mysqli, $keyword_id){
		
		//setup the prepared statement for the delete query
		$query = "DELETE FROM keywords WHERE keyword_id=?";
		$statement = $mysqli->prepare($query);
		
		//bind parameters for markers where (s=string, i=integer, d=double, b=blob)
		$statement->bind_param('i',$keyword_id);
		
		//execute query and print any errors that occur
		if(!$statement->execute()){
			print 'Failed to DELETE FROM (keywords table): '.$keyword_id;
			return false;
		}
		
		addKeywordCredits($mysqli,1);
		return true;
	}
	
	
	//returns assoc array of all keywords in an array with associated user_name
	//no external parameters needed so we don't use prepared statement
	function getAllKeywordArray($mysqli){
		$query = "SELECT keyword_name, user_name FROM keywords";
		$results = $mysqli->query($query);
		$output_array = array();
		
		while($row = $results->fetch_assoc()){
			$output_array[$row["keyword_name"]] = $row["user_name"];
		}

		return $output_array;
	}
	
	//returns the autoreply text and num_msgs used for the $keyword in an array
	//returns null if it has not been setup
	function getAutoReply($mysqli, $keyword){
		//create the prepared statement
		$query = "SELECT keyword_response,keyword_msgs_used FROM keywords WHERE keyword_name=?";
		$statement = $mysqli->prepare($query);
		
		//bind parameters for markers where (s=string, i=integer, d=double, b=blob)
		$statement->bind_param('s',$keyword);
		
		//execute query
		$statement->execute();
		
		//bind result variables
		$statement->bind_result($autoreply, $num_msg);
		
		$output = array();
		while($statement->fetch()) {

			$output['text'] = $autoreply;
			$output['num_msg'] = $num_msg;
		}
	
		return $output;
	}
	
	
	//returns the keywords associated with the user in html list item
	//if $checkbox===true, we include a checkbox in each row for subsequent record deletion
	
	function displayKeywords($mysqli, $checkbox){
		$user_name = $_SESSION['user_name'];
	
		//create the prepared statement
		$query = "SELECT keyword_id, keyword_name FROM keywords WHERE user_name=?";
		$statement = $mysqli->prepare($query);
		
		//bind parameters for markers where (s=string, i=integer, d=double, b=blob)
		$statement->bind_param('s',$user_name);
		
		//execute query
		$statement->execute();
		
		//bind result variables
		$statement->bind_result($keyword_id,$keyword_name);
		
		//fetch records into html table row
		if($checkbox){
			while($statement->fetch()) {
				
				print '<tr>';
				print '<td><input type="checkbox" name="checkbox[]" value='.$keyword_id.' id="checkbox"></td>';
				print '<td>'.$keyword_name.'</td>';
				print '</tr>';
			}
		}
		else {
			while($statement->fetch()) {
				print '<tr>';
				print '<td>'.$keyword_name.'</td>';
				print '</tr>';
			}
		}
	}

	
	//returns account information (user_name, account_type,sms_credits) in html table row
	function getAccountInfo($mysqli){

		$user_name = $_SESSION['user_name'];
	
		//create the prepared statement
		$query = "SELECT user_name, account_type, sms_credits, keyword_credits FROM accounts WHERE user_name=?";
		$statement = $mysqli->prepare($query);
		
		//bind parameters for markers where (s=string, i=integer, d=double, b=blob)
		$statement->bind_param('s',$user_name);
		
		//execute query
		$statement->execute();
		
		//bind result variables
		$statement->bind_result($user_name,$account_type,$sms_credits,$keyword_credits);
		
		//fetch records into html table row
		while($statement->fetch()) {
			print '<tr>';
			print '<td>'.$user_name.'</td>';
			print '<td>'.$account_type.'</td>';
			print '<td>'.$sms_credits.'</td>';
			print '<td>'.$keyword_credits.'</td>';
			print '</tr>';
		}  
	}
	
	//updates the accounts table with the necessary $deduction from the user's keyword_credits
	//Returns true if completed successfully, false otherwise
	function subtractKeywordCredits($mysqli,$deduction){

		$user_name = $_SESSION['user_name'];
	
		//create the prepared statement
		$query = "UPDATE accounts SET keyword_credits = keyword_credits - ? WHERE user_name=?";
		$statement = $mysqli->prepare($query);
		
		//bind parameters for markers where (s=string, i=integer, d=double, b=blob)
		$statement->bind_param('ss',$deduction,$user_name);
		
		//execute query and print any errors that occur
		if(!$statement->execute()){
			print 'Failed to update accounts table with deduction: '.$deduction;
			return false;
		}
		return true;
	}
	
	//updates the accounts table with the necessary $addition to the user's keyword_credits
	//Returns true if completed successfully, false otherwise
	function addKeywordCredits($mysqli,$addition){

		$user_name = $_SESSION['user_name'];
	
		//create the prepared statement
		$query = "UPDATE accounts SET keyword_credits = keyword_credits + ? WHERE user_name=?";
		$statement = $mysqli->prepare($query);
		
		//bind parameters for markers where (s=string, i=integer, d=double, b=blob)
		$statement->bind_param('ss',$addition,$user_name);
		
		//execute query and print any errors that occur
		if(!$statement->execute()){
			print 'Failed to update accounts table with addition: '.$addition;
			return false;
		}
		return true;
	}
	
	
	//updates the accounts table with the necessary $deduction from the user's sms_credits
	//Returns true if completed successfully, false otherwise
	function subtractUserCredits($mysqli,$deduction){

		$user_name = $_SESSION['user_name'];
	
		//create the prepared statement
		$query = "UPDATE accounts SET sms_credits = sms_credits - ? WHERE user_name=?";
		$statement = $mysqli->prepare($query);
		
		//bind parameters for markers where (s=string, i=integer, d=double, b=blob)
		$statement->bind_param('ss',$deduction,$user_name);
		
		//execute query and print any errors that occur
		if(!$statement->execute()){
			print 'Failed to update accounts table with deduction: '.$deduction;
			return false;
		}
		return true;
	}
	
	//updates the accounts table with the necessary $addition to the user's sms_credits
	//Returns true if completed successfully, false otherwise
	function addUserCredits($mysqli,$addition){

		$user_name = $_SESSION['user_name'];
	
		//create the prepared statement
		$query = "UPDATE accounts SET sms_credits = sms_credits + ? WHERE user_name=?";
		$statement = $mysqli->prepare($query);
		
		//bind parameters for markers where (s=string, i=integer, d=double, b=blob)
		$statement->bind_param('ss',$addition,$user_name);
		
		//execute query and print any errors that occur
		if(!$statement->execute()){
			print 'Failed to update accounts table with addition: '.$addition;
			return false;
		}
		return true;
	}
	
	/* Updates outbound_num_delivered field of $ref_id with the $addition number of SMSes delivered  */
	function updateOutboundDelivery($mysqli, $ref_id, $addition){
	
		//create the prepared statement
		$query = "UPDATE outbound SET outbound_num_delivered = outbound_num_delivered + ? WHERE outbound_ref_id=?";
		$statement = $mysqli->prepare($query);
		
		//bind parameters for markers where (s=string, i=integer, d=double, b=blob)
		$statement->bind_param('ss',$addition,$ref_id);
		
		//execute query and print any errors that occur
		if(!$statement->execute()){
			print 'Failed to update outbound table with num_delivered: '.$ref_id;
			return false;
		}
		return true;
		
	}
	
	/* Updates outbound_log field of $ref_id with log messages from callback url  */
	function updateOutboundLog($mysqli, $ref_id, $log_msg){
		//create the prepared statement
		$query = "UPDATE outbound SET outbound_log = CONCAT(ifnull(outbound_log,''), ?) WHERE outbound_ref_id=?";
		$statement = $mysqli->prepare($query);
		
		//bind parameters for markers where (s=string, i=integer, d=double, b=blob)
		$statement->bind_param('ss',$log_msg,$ref_id);
		
		//execute query and print any errors that occur
		if(!$statement->execute()){
			print 'Failed to update outbound table with delivery log. Ref ID: '.$ref_id;
			return false;
		}
		return true;
		
		
	}
	
	/* Updates outbound_status field of $ref_id with status updates, $is_success, from callback url  */
	function updateOutboundStatus($mysqli, $ref_id, $is_success){
	
		$new_status = "";
		//prepare the new outbound status message
		if($is_success){
			$new_status = "SUCCESS";
		}
		else{
			$new_status = "ERRORS, SEE LOG";
		}
		
		//create the prepared statement
		$query = "UPDATE outbound SET outbound_status = ? WHERE outbound_ref_id=?";
		$statement = $mysqli->prepare($query);
		
		//bind parameters for markers where (s=string, i=integer, d=double, b=blob)
		$statement->bind_param('ss',$new_status,$ref_id);
		
		//execute query and print any errors that occur
		if(!$statement->execute()){
			print 'Failed to update outbound table with status: '.$new_status.'. Ref ID: '.$ref_id;
			return false;
		}
		return true;
		
	}
	/*	we insert the $sender and $msg into the inbound table
		Also populates the inbound_users database
		Returns true if completed successfully, false otherwise */
	function uploadInboundInfo($mysqli,$sender,$msg,$user){
		//create the prepared statement
		$query = "INSERT INTO inbound (inbound_from, inbound_text) VALUES (?,?)";
		$statement = $mysqli->prepare($query);
		
		//bind parameters for markers where (s=string, i=integer, d=double, b=blob)
		$statement->bind_param('ss',$sender,$msg);
		
		//execute query and print any errors that occur
		if(!$statement->execute()){
			print 'Failed to insert (inbound table): '.$sender.' / '.$msg;
			return false;
		}
		//inbound info has been successfully inserted into inbound table
		//we now insert its corresponding (inbound,user) mapping into inbound_users table
		else {
			//We get the last inserted inbound_id
			$query2 = "SELECT MAX(inbound_id) AS inbound_id FROM inbound";
			$inbound_id = $mysqli->query($query2)->fetch_object()->inbound_id;
			
			//and insert it into outbound_users with the user_name
			$query3 = "INSERT INTO inbound_users (inbound_id,user_name) VALUES (?,?)";
			$statement3 = $mysqli->prepare($query3);
			$statement3->bind_param('ss',$inbound_id, $user);
			
			//execute query and print any errors that occur
			if(!$statement3->execute()){
				print 'Failed to insert (inbound_users table). inbound_id: '. $inbound_id . ' & user_name: ' . $user;
				return false;
			}
			return true;
			
		}
	}
	
	
	
	/*	Takes in an associative array, $data, and inserts its contents into the outbound database
		Also populates the outbound_users database
		Returns true if completed successfully, false otherwise
	*/
	function uploadOutboundInfo($mysqli,$data){
		$user_name = $_SESSION['user_name'];
		
		//create the prepared statement
		$query = "INSERT INTO outbound (outbound_ref_id,outbound_title,outbound_from,outbound_to,outbound_text,outbound_status,outbound_credits_used) VALUES (?,?,?,?,?,?,?)";
		$statement = $mysqli->prepare($query);
		
		//bind parameters for markers where (s=string, i=integer, d=double, b=blob)
		$statement->bind_param('sssssss',$data['api_ref_id'],$data['title'],$data['from'],$data['to'],$data['text'],$data['status'],$data['credits_used']);
		
		//execute query and print any errors that occur
		if(!$statement->execute()){
			print 'Failed to insert (outbound table): '.$data['api_ref_id'].' / '.$data['title'];
			return false;
		}
		//outbound info has been successfully inserted into outbound table
		//we now insert its corresponding (outbound,user) mapping into outbound_users table
		else {
			//We get the last inserted outbound_id
			$query2 = "SELECT MAX(outbound_id) AS outbound_id FROM outbound";
			$outbound_id = $mysqli->query($query2)->fetch_object()->outbound_id;
			
			//and insert it into outbound_users with the user_name
			$query3 = "INSERT INTO outbound_users (outbound_id,user_name) VALUES (?,?)";
			$statement3 = $mysqli->prepare($query3);
			$statement3->bind_param('ss',$outbound_id, $user_name);
			
			//execute query and print any errors that occur
			if(!$statement3->execute()){
				print 'Failed to insert (outbound_users table). outbound_id: '. $outbound_id . ' & user_name: ' . $user_name;
				return false;
			}
			return true;
		}
		
		
	}
	
	/* 	Takes in a $keyword with any $autoreply, and inserts it into the keywords table */
	function uploadKeyword($mysqli, $keyword, $autoreply, $num_msg){

		$user_name = $_SESSION['user_name'];
		//check if user wants to setup autoreply for this keyword
		//and create the appropriate prepared statement
		if($autoreply===""){
			$query = "INSERT INTO keywords (keyword_name, user_name) VALUES (?,?)";
		}
		else {
			$query = "INSERT INTO keywords (keyword_name, user_name, keyword_response, keyword_msgs_used) VALUES (?,?,?,?)";
		}

		//create the prepared statement
		$statement = $mysqli->prepare($query);
		
		//bind parameters for markers where (s=string, i=integer, d=double, b=blob)
		if($autoreply===""){
			$statement->bind_param('ss',$keyword,$user_name);
		}
		else {
			$statement->bind_param('ssss',$keyword,$user_name,$autoreply,$num_msg);
		}

		//execute query and print any errors that occur
		if(!$statement->execute()){
			print 'Failed to insert (keywords table): '.$keyword;
			return false;
		}
		//keyword inserted successfully, now we deduct it from keyword_credits in accounts table
		else {
			subtractKeywordCredits($mysqli,1);
			return true;
		}
		
	}
	
	/* 	takes in an array, $data, and inserts its contents into the contacts table
		assumes that 1st element holds contact_name and 2nd element holds entire phone number incl. country code
		also populates contacts_users database  */
	function uploadContactsInfo($mysqli, $data){
		//include format checking function
		require_once("classes/formatting.php");
		
		$raw_num = $data[1];
		$processed_num = cleanSGNum($raw_num);
		
		//we check if phone number is in correct format and generate warning if not
		if (!checkSGNum($processed_num)){
			print $raw_num.' has invalid phone format. Please use 65XXXXXXXX';
			return false;
		}

		$user_name = $_SESSION['user_name'];
	
		//create the prepared statement
		$query = "INSERT INTO contacts (contact_name, contact_country_code, contact_number) VALUES (?,?,?)";
		$statement = $mysqli->prepare($query);
		
		//bind parameters for markers where (s=string, i=integer, d=double, b=blob)
		//we parse the $data[1], into country code and phone number
		$contact_name = $data[0];
		$contact_country_code = substr($processed_num,0,2);
		$contact_number = substr($processed_num,2,8);
		$statement->bind_param('sss',$contact_name,$contact_country_code,$contact_number);
		
		//execute query and print any errors that occur
		if(!$statement->execute()){
			print 'Failed to insert (contacts table): '.$data[0];
			return false;
		}
		
		//contact info has been successfully inserted into contacts table
		//we now insert its corresponding (contact,user) mapping into contacts_users table
		else {
			//We get the last inserted contact_id
			$query2 = "SELECT MAX(contact_id) AS contact_id FROM contacts";
			$contact_id = $mysqli->query($query2)->fetch_object()->contact_id;
			
			//and insert it into contacts_users with the user_name
			$query3 = "INSERT INTO contacts_users (contact_id,user_name) VALUES (?,?)";
			$statement3 = $mysqli->prepare($query3);
			$statement3->bind_param('is',$contact_id, $user_name);
			
			//execute query and print any errors that occur
			if(!$statement3->execute()){
				print 'Failed to insert (contacts_users table). contact_id: '. $contact_id . ' & user_name: ' . $user_name;
				return false;
			}
			return true;
		}

	}
	

	
 ?>