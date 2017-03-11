<?php
    /*  
    Parameter Example
        $data = array('post_id'=>'12345','post_title'=>'A Blog post');
        $target = 'single tocken id or topic name';
        or
        $target = array('token1','token2','...'); // up to 1000 in one request
    */

        echo "Start<br/>";
		
		$myMessage = "hello";
		

		$message = array("message" => $myMessage);

        $result = sendMessage($message,null);
        var_dump($result);

        function sendMessage($data,$target){
            //FCM api URL
            $url = 'https://fcm.googleapis.com/fcm/send';
            //api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
            $server_key = 'AAAABpwgTqI:APA91bHN7IJduewvn84BBcpVS7v8Dg82x6RgZzkRtyAYeiLDHs7acKdY9FoWp2MKe_O0RM2sCiEKDC2O0cR04xDGKv9iRR9zBQa4pYRvJ7cqThPOdrWTj3HPf5If4-TA-yDTcDbyuGNs';

            $fields = array();
            //$fields['data'] = $data;
			//$fields['registration_ids'] = 'eFVzB330BVk:APA91bGnuTBf9ad85j9aOcMIKBvB1guNSMuMOKjjfrfmUIzvm56DmnAqAQcwyQdiSyqdipNUyaHXTcuc6PLmAEbLNMQEGbwRtpYrFMve1Uqk7iI0m5IICyupBcSkfsqg6zmU7GujJR-f';
            
			$fields['to']='dM5_S-QsNiA:APA91bHwKRrzu3aY5uyIDXvnW3-If0GICRM1TvVgDoLuJnfyl0puEAIth5Vs26sE8N_4t2Hb_qX01Mnvrge5nh7znc8HvcPNyS_ENlGWpvYBCq6j4nG9wpmtjV08YF8YqkONt_sLTNpH';
			//$fields['to']='eFVzB330BVk:APA91bGnuTBf9ad85j9aOcMIKBvB1guNSMuMOKjjfrfmUIzvm56DmnAqAQcwyQdiSyqdipNUyaHXTcuc6PLmAEbLNMQEGbwRtpYrFMve1Uqk7iI0m5IICyupBcSkfsqg6zmU7GujJR-f';
			$fields['notification'] = array('body' => 'test_body', 'title' => 'test_title');
			$fields['data'] = array('go_to_url' => 'http://unit.kr');
            //$fields['dry_run']=true;


            //header with content_type api key
            $headers = array(
                'Authorization:key='.$server_key,
				'Content-Type:application/json'
                );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            if ($result === FALSE) {
                die('FCM Send Error: ' . curl_error($ch));
            } 
            curl_close($ch);
            return $result;
        }

?>
<script src="https://www.gstatic.com/firebasejs/3.6.9/firebase.js"></script>
<script>
  // Initialize Firebase
  var config = {
    apiKey: "AAAABpwgTqI:APA91bHN7IJduewvn84BBcpVS7v8Dg82x6RgZzkRtyAYeiLDHs7acKdY9FoWp2MKe_O0RM2sCiEKDC2O0cR04xDGKv9iRR9zBQa4pYRvJ7cqThPOdrWTj3HPf5If4-TA-yDTcDbyuGNs",
    authDomain: "messaging-10868.firebaseapp.com",
    databaseURL: "https://messaging-10868.firebaseio.com",
    storageBucket: "messaging-10868.appspot.com",
    messagingSenderId: "28389166754"
  };
  firebase.initializeApp(config);
</script>