<?php
/**
 * Custom contact orm ajax handler function
 */
add_filter('acf/load_field/name=client_name', 'acf_read_only');
add_filter('acf/load_field/name=client_lastname', 'acf_read_only');
add_filter('acf/load_field/name=client_tel', 'acf_read_only');
add_filter('acf/load_field/name=client_email', 'acf_read_only');
add_filter('acf/load_field/name=client_type', 'acf_read_only');
add_filter('acf/load_field/name=client_message', 'acf_read_only');

function acf_read_only($field) {
	$field['readonly'] = 1;
	return $field;
}

if( !function_exists('ajax_contact_form') ) {
    add_action( 'wp_ajax_sendcontactform', 'ajax_contact_form' );
	add_action( 'wp_ajax_nopriv_sendcontactform', 'ajax_contact_form' );

    function curl_post($url = '', $data = null, $token = null , $method = 'POST') {
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); 
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_POST, 1);
        if( !empty($data) )
        {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            $header = [];
            $header[] = 'Content-Type: application/json';
            $header[] = 'Content-Length: '.strlen(json_encode($data));
            if( $token !== null )
            {
                $header[] = 'Authorization: Bearer ' . $token;
            }
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        }
        $result = curl_exec($curl);
        $headers = curl_getinfo($curl);
        curl_close($curl);
        $result = json_decode($result);
        return $result;
    }

    function ajax_contact_form() {
        if( isset($_POST) ) {
            $client_name = $_POST['name'];
            $client_lastname = $_POST['lastname'];
            $client_tel = $_POST['tel'];
            $client_email = $_POST['email'];
            $client_type = $_POST['type'];
            $client_message = $_POST['message'];
            $client_newsletter = $_POST['newsletter'];
            $post_title = 'Bewerbungen über das Kontaktformular unter: '.date('d/m/Y G:i');

            $response = array();

            if(get_field('from_emails','options')) {
                $to = strval( get_field('from_emails','options') );
                switch( $client_type ) {
                    case 'Insvestoren':
                        $to.= ',investoren@gartenpark-korneuburg.at';
                    break;
    
                    case 'Ärztezentrum':
                        $to.= ',aerzte@gartenpark-korneuburg.at';
                    break;
    
                    case 'Mieter':
                        $to.= ',mieter@gartenpark-korneuburg.at ';
                    break;
    
                    case 'Für Komfortgäste':
                        $to.= ',komfortfertig@gartenpark-korneuburg.at';
                    break;
                }
			} else {
                $to = get_option('admin_email');
                switch( $client_type ) {
                    case 'Insvestoren':
                        $to.= ',investoren@gartenpark-korneuburg.at';
                    break;
    
                    case 'Ärztezentrum':
                        $to.= ',aerzte@gartenpark-korneuburg.at';
                    break;
    
                    case 'Mieter':
                        $to.= ',mieter@gartenpark-korneuburg.at ';
                    break;
    
                    case 'Für Komfortgäste':
                        $to.= ',komfortfertig@gartenpark-korneuburg.at';
                    break;
                }
			}
			
			$message = '';
			$site_base = site_url();
			$site_base = preg_replace('#^https?://#', '', $site_base);
			$from = 'noreply@'.$site_base;
						
			$subject = 'Bewerbung über Kontaktformular';
			$sender = 'From: Gartenpark <'.$from.'>' . "\r\n";
				
			$message.='<p><b>Nahname: </b> '. $client_name .'</p>';
			$message.='<p><b>Vorname: </b> '. $client_lastname .'</p>';
			$message.='<p><b>Tel. : </b> '. $client_tel  .'</p>';
			$message.='<p><b>E-mail: </b> '. $client_email .'</p>';
			$message.='<p><b>Type: </b> '. $client_type .'</p>';
                
            if( $_POST['message'] ) {
				$message.='<p><b>Message: </b> '. $client_message .'</p>';
			}
			
			$headers[] = 'MIME-Version: 1.0' . "\r\n";
			$headers[] = 'Content-type: text/html; charset=UTF-8' . "\r\n";
			$headers[] = "X-Mailer: PHP \r\n";
			$headers[] = $sender;
							
            $mail = wp_mail( $to, $subject, $message, $headers );

            
                $specialErrors = array();
                $group_id = null;
                $form_id = null;
                $client_type_interes = '';

                switch( $client_type ) {
                    case 'Insvestoren':
                        $client_type_interes = 'Investition';
                    break;
    
                    case 'Ärztezentrum':
                        $client_type_interes = 'Ärztezentrum';
                    break;
    
                    case 'Mieter':
                        $client_type_interes = 'Mietwohnungen';
                    break;
    
                    case 'Für Komfortgäste':
                        $client_type_interes = 'Komfortfertiges Wohnen';
                    break;
                }

                if( $client_newsletter == 'checked' ) {
                    $group_id = 1098826;
                    $form_id = 266913;
                } else {
                    switch( $client_type ) {
                        case 'Insvestoren':
                            $group_id = 1098822;
                            $form_id = 266912;
                        break;
        
                        case 'Ärztezentrum':
                            $group_id = 1098827;
                            $form_id = 266914;
                        break;
        
                        case 'Mieter':
                            $group_id = 1098824;
                            $form_id = 266915;
                        break;
        
                        case 'Für Komfortgäste':
                            $group_id = 1098823;
                            $form_id = 266916;
                        break;
                    }
                }
        
                
                $data = (object)[
                    'api' => 'https://rest.cleverreach.com/v2/',
                    'email' => $client_email,
                    'group_id' => $group_id,
                    'form_id' => $form_id,
                    'client_id' => 268370,
                    'username' => 'sergej@impltech.com',
                    'password' => 'rUgswToC',
                    'token' => null,
                    'source' => get_home_url(),
                    'global_attributes' => null,
                    'attributes' => null
                ];


                $data->global_attributes = [
                    'nachname' => $client_lastname,
                    'vorname' => $client_name,
                    'telefonnummer' => $client_tel,
                    'nachricht' => $client_message,
                    'interessiert_an' => $client_type_interes
                ];

                
                $responsePost = curl_post(
                    $data->api.'login.json',
                     [
                    'client_id' => $data->client_id,
                    'login' => $data->username,
                    'password' => $data->password
                ]);
                
                if( isset($responsePost->error) ) { 
                    $specialErrors['error'][] = 'error in retrive access token'; 
                }
                
                $data->token = $responsePost;
                
                /* add recipient (unverified) */
                $responsePostRecipientsBasic = curl_post($data->api.'groups.json/'.$data->group_id.'/receivers', [
                    'email' => $data->email,
                    'registered' => time(),
                    'activated' => 0,
                    'source' => $data->source,
                    'attributes' => $data->global_attributes,
                    'global_attributes' => $data->global_attributes
                ], $data->token);
                
                if( isset($responsePostRecipientsBasic->error) ) { 
                    $specialErrors['error'][] = 'error in retrive insert recipeties'. json_encode($responsePostRecipientsBasic->error); 
                }
                
                $responsePostForm = curl_post( 'https://rest.cleverreach.com/v2/forms.json/'. $data->form_id .'/send/activate', [
                    'email' => $data->email,
                    'doidata' => [
                        'user_ip' => $_SERVER['REMOTE_ADDR'],
                        'referer' => $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'],
                        'user_agent' => $_SERVER['HTTP_USER_AGENT']
                    ]
                ], $data->token);

                //'groups_id' => $data->group_id
                if( isset($responsePostForm ->error) ) { 
                    $specialErrors['error'][] = 'error in insert form subscribe:'. json_encode($responsePostForm ->error); 
                }


                $responsePostAttr = curl_post( 'https://rest.cleverreach.com/v2/attributes.json', [
                    'token' => $data->token
                ], $data->token, 'GET');
            
            $application_data = array(
                'post_title' => $post_title,
                'post_status' => 'publish',
                'post_type' => 'application',
                'post_author' => get_current_user_id()
            );

            $new_post = wp_insert_post($application_data, true);
            if( !is_wp_error($new_post) ) {
                update_field('client_name', $client_name, $new_post);
                update_field('client_lastname', $client_lastname, $new_post);
                update_field('client_tel', $client_tel, $new_post);
                update_field('client_email', $client_email, $new_post);
                update_field('client_type', $client_type, $new_post);
                update_field('client_message', $client_message, $new_post);
            };
            
				
			if( $mail and !is_wp_error($new_post) ) {
				$response['response'] = 'SUCCESS';
				$response['clever_reach'] = json_encode($specialErrors).'---'.json_encode($responsePostAttr);
			} else {
				$response['response'] = 'ERROR';
				$response['error'] = $mail.'---'.$new_post.'---'.json_encode($specialErrors);
			}
			
            echo json_encode( $response );
        }

        die();
    }
}