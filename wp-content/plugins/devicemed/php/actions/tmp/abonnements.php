<?php

function suite_formulaire_abonnement($abo) {


if($offre = $GLOBALS['abonnements'][$abo['mode']]['datas'][$abo['offre']]) {
	$nom = mb_strtoupper(remove_accents($abo['nom']));
	if($abo['mode'] != 'digital') {
		foreach(array(
				'!empty'=>array(
					'fields'=> array('nom','adresse','code_postal','ville','pays'),
					'message'=> 'Veuillez remplir les champs nom, adresse, code postal, ville et pays',
				),
				'is_email'=>array(
					'fields'=>array('email'),
					'message'=> 'Adresse email invalide',
				)
			) as $fn =>$data){
			foreach($data['fields'] as $field) {
				eval('$test = '.$fn.'($abo['.$field.']);');
				if(!$test) {
					Alert::error('Erreur',$data['message']);
					wp_redirect(SOCIETY_SITEURL.'/abonnements-a-society/');
					exit;
				}
			}
		}
		if(!empty($abo['cadeau'])){
			$nom.=' cadeau offert par '.mb_strtolower($abo['gift_email']);
		}
		$adresse = mb_strtoupper(remove_accents($abo['adresse'].PHP_EOL.$abo['code_postal'].' '.$abo['ville'].' ('.$abo['pays'].')'));
	} else {
		$adresse='';
	}

if($abo['digital']) {
	$code_paypal = $offre['+digital'];
} else {
	$code_paypal = $offre['paypal'];
}
?>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="<?php echo $code_paypal;?>">
<input type="image" src="http://i.snag.gy/mCmL0.jpg"  width="1" height="1" border="0" name="submit" alt="PayPal - la solution de paiement en ligne la plus simple et la plus sécurisée !">
<img alt="" border="0" src="https://www.paypalobjects.com/fr_FR/i/scr/pixel.gif" width="1" height="1">
<input type="hidden" name="on0" value="Nom">
<input type="hidden" name="on1" value="Adresse">
<input type="hidden" name="on2" value="Email">
<input type="hidden" name="os0" value="<?php echo htmlspecialchars($nom);?>">
<input type="hidden" name="os1" value="<?php echo htmlspecialchars($adresse);?>">
<input type="hidden" name="os2" value="<?php echo htmlspecialchars(mb_strtolower($abo['email']));?>">
</form>
<script>document.forms[0].submit();
</script>
<?php
exit;
}
}