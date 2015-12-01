<?php

/**
Classe permettant d'envoyer des messages d'une page à une autre
**/

class Alert{
	public function success($title,$text=''){
		Alert::set($title,$text,'success');
	}
	public function warning($title,$text=''){
		Alert::set($title,$text,'warning');
	}
	public function error($title,$text=''){
		Alert::set($title,$text,'danger');
	}
	public function set($title,$text='',$type='success'){
		if(empty($_SESSION['message'])) {
			$_SESSION['message'] = array('title'=>$title,'text'=>$text,'type'=>$type);
		}
	}
	public function get(){
		if(isset($_SESSION['message']) && is_array($_SESSION['message'])) {
			$ret = $_SESSION['message'];
			unset($_SESSION['message']);
		} else {
			$ret=false;
		}
		return $ret;
	}
	public function display($message=false){
		if(!$message) {
			$message = Alert::get();
		}
		if($message) {
			if(!isset($message['type'])) {
				$message['type']='success';
			}
				ob_start();
		?>
			<div <?php echo ($id = sinon($message,'id')) ? 'id="'.$id.'"' : '';?> class="<?php echo sinon($message,'class');?> alert alert-<?php echo $message['type'];?>" role="alert"><strong><?php echo sinon($message,'title');?></strong> <?php echo $message['text'];?> </div>
		<?php
		   $out = ob_get_contents();
		   ob_end_clean();
			if(!empty($message['return'])) {
					return $out;
			} else {
				echo $out;
			}
		}
	}
}
