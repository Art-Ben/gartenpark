<?php
/**
 * Custom contact orm ajax handler function
 */

use rdoepner\CleverReach\ApiManager;
use rdoepner\CleverReach\Http\Guzzle as HttpAdapter;

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
				$to = get_field('from_emails','options');
			} else {
				$to = get_option('admin_email');
			}
			
			$message = '';
			$site_base = site_url();
			$site_base = preg_replace('#^https?://#', '', $site_base);
			$from = 'info@'.$site_base;
						
			$subject = 'Bewerbung über Kontaktformular';
			$sender = 'From: Gartenpark <'.$from.'>' . "\r\n";
				
			$message.='<p><b>Nahname: </b> '. $client_name .'</p>';
			$message.='<p><b>VorName: </b> '. $client_lastname .'</p>';
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

            if( $client_newsletter == 'checked' ) {                
                $message = '';
                $site_base = site_url();
                $site_base = preg_replace('#^https?://#', '', $site_base);
                $fromSpec = 'special@'.$site_base;
						
                $subject = 'Abonnieren Sie den Newsletter';
                $sender.= 'From: Gartenpark <'. $fromSpec.'>'. "\r\n";         
                $sender.= 'Reply-To: '. $fromSpec . "\r\n";         
                    
                $message.='Test, in this field can make different content and html';
                
                $headersSpec[] = 'MIME-Version: 1.0' . "\r\n";
                $headersSpec[] = 'Content-type: text/html; charset=UTF-8' . "\r\n";
                $headersSpec[] = "X-Mailer: PHP \r\n";
                $headersSpec[] = $sender;

                $httpAdapter = new HttpAdapter();

                $response = $httpAdapter->authorize('0WFnsmGEfP', 'bFh5KNhNbdhCVhklb61GhYzMk4HRgtiX');
							
                if (isset($response['access_token'])) {
                    $httpAdapter = new HttpAdapter(
                        [
                            'access_token' => $response['access_token'],
                        ]
                    );
                    
                    $apiManager = new ApiManager($httpAdapter);
                    $response = $apiManager->createSubscriber(
                        $client_email,
                        '1096365',
                        true,
                        [
                            'Vorname' => $client_name,
                            'Nachname' => $client_lastname,
                            'Telephone' => $client_tel,
                            'Interessiert für' => $client_type
                        ]
                    );
                }
            }
            
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
            
				
			if( $mail and !is_wp_error($new_post) and isset($response['id']) ) {
				$response['response'] = 'SUCCESS';
			} else {
				$response['response'] = 'ERROR';
				$response['error'] = $mail.'---'.$new_post.'---'.$response;
			}
			
            echo json_encode( $response );
         }

         die();
     }
 }