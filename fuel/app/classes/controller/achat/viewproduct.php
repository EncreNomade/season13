<?php
class Controller_Achat_Viewproduct extends Controller_Season13 
{
    public function action_404 () {        
        return View::forge('achat/13product/404');
    }

    public function action_webservice($ref) {
        // Check ref
        if(!isset($ref)) {
            Response::redirect('ws/product/404');
        }
    
        // Check user
        $user = Input::param('user');
        if(is_null($user)) {
            Response::redirect('ws/product/404');
        }
        // Check token and token-email association
        $access_token = Input::param('access_token');
        if( is_null($access_token) || 
            !Controller_Webservice_Wsbase::checkAccessToken($access_token, $user, $ref) ) {
            Response::redirect('ws/product/404');
        }
        
        // Check product existance
        $product = Model_Achat_13product::find_by_reference($ref);
        if(is_null($product)) {
            Response::redirect('ws/product/404');
        }
        
        // Other type of content not supported yet
        if($product->type != 'episode') {
            Response::redirect('ws/product/404');
        }
        
        // Retrieve content
        $arr = Format::forge($product->content, 'json')->to_array();
        // No content
        if(count($arr) == 0 || !isset($arr[0]))
            Response::redirect('ws/product/404');
        
        // Single episode product
        if($product->pack == 0) {
            $epid = $arr[0];
            $ep = Model_Admin_13episode::find($epid);
            // Episode not found
            if(is_null($ep))
                Response::redirect('ws/product/404');
            
            // Params    
            $story = str_replace(' ', '_', $ep->story);
            $result = Controller_Webservice_Wsbase::decryptAccessToken($access_token);
            $access_token = Controller_Webservice_Wsbase::cryptAccessToken($result['email'], $result['appid'], $story.$ep->season.$ep->episode);
            // Redirect to story
            Response::redirect('ws/'.$story.'/season'.$ep->season.'/episode'.$ep->episode.'?user='.$user.'&access_token='.$access_token);
        }
        
        // Package product, show package view
        $eps = array();
        foreach ($arr as $epid) {
            $ep = Model_Admin_13episode::find($epid);
            
            $story = str_replace(' ', '_', $ep->story);
            $result = Controller_Webservice_Wsbase::decryptAccessToken($access_token);
            $token = Controller_Webservice_Wsbase::cryptAccessToken($result['email'], $result['appid'], $story.$ep->season.$ep->episode);
            
            $link = $this->remote_path."ws/".$story."/season".$ep->season."/episode".$ep->episode."?user=".$user."&access_token=".$token;
            
            array_push($eps, array('obj' => $ep, 'link' => $link, 'token' => $token));
        }
        
        $data['product'] = $product;
        $data['episodes'] = $eps;
        $data['user'] = $user;

        return View::forge('achat/13product/package', $data);
    }
    
    //http://www.season13.com/ws/product/ISBN9782717765894?user=test@test.com&access_token=_C-6mha59555YXnTRPXrRRFnllSLWgE_I1RtCuD5xUadUHWC4Io0D01IuBRNKDkE0mGuF0s7yGJrwL9LmqauHWKhylhXrdvVcLz2PsAJOr6f7UKFR-dsWmIoU7WfkybbbWoycHdiZFlBenVpU0lHdVE2SG0yTWpfNnFyR01BSG9mQW5zWkg4dDEyQQ
}