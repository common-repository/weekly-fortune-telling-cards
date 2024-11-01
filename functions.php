<?php
/* ------------- */
/* Plugin Activation */
/* ------------- */

function power_weekly_cards_plugin($atts) {
$frm_cont = $credits = '';
$chkSigns=array('Aries','Taurus','Gemini','Cancer','Leo','Virgo','Libra','Scorpio','Sagittarius','Capricorn','Aquarius','Pisces');
$para = shortcode_atts(array('sign' => '','allowinfo' => ''),$atts);
$allowinfo = strtolower($para['allowinfo']);
$arr_wk = $multi = array();
if(isset($para['sign']) && $para['sign']!=='' && in_array($para['sign'],$chkSigns)){
$multi[] = $para['sign'];
} else {
$multi=$chkSigns;
}

$abslt_url = "https://www.powerfortunes.com/cron/powerfortunes_fortunetellingcards_weekly.json";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$abslt_url);
curl_setopt($ch, CURLOPT_TIMEOUT, 1600);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
$json_wk=curl_exec($ch);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
if($status_code == 200) {
$arr_wk = json_decode($json_wk, true);
} else {
$arr_wk = array();
}
?>

<!-- Start of Code for weekly Zodiac Signs -->
<div class="grid-container">
<?php
if(empty($arr_wk)){
$frm_cont = '<div class="wrap-fit bord_cardhd"><div class="box_title card_hd_spc">Weekly Fortune Telling Cards are presently unavailable.</div></div>';
}//if
else {
$k = 0;
foreach($multi as $sn){
$signs_lnk[] = $sn;
if($k > 0){
$lzy = ' loading="lazy"';
} else {
$lzy = '';
}
$frm_cont .= '<div class="wrap-fit bord_cardhd"><div class="box_title card_hd_spc">Weekly Fortune Telling Cards for '.$sn.'</div></div>';
for($i=0; $i<=3; $i++){
$frm_cont .='<img src="'.$arr_wk[strtoupper($sn)][$i].'"'.$lzy.' alt="'.$sn.', the fortune telling card for '.$sn.' for this week." class="borderRnd flx_card">';
	}// for
$k++;
}// foreach

if($allowinfo==='yes' && !empty($arr_wk)){
$credits = '<div id="box_pfcard" class="left clrfix_crd">';
if(!isset($signs_lnk)){
$credits .= '<div class="box_cards45 spacer_hz f_spc">&nbsp;<a rel="noopener noreferrer nofollow" href="https://www.powerfortunes.com/fortunetellingcards.php" target="_blank">What are these cards?</a></div><!-- box_cards45 -->';
} else if(in_array($chkSigns[1],$signs_lnk) || in_array(end($chkSigns),$signs_lnk)){ 
$credits .= '<div class="box_cards45 spacer_hz f_spc">&nbsp;<a rel="noopener noreferrer nofollow" href="https://www.powerfortunes.com/fortunetellingcards.php#What are these cards" target="_blank">What are these cards?</a>
</div><!-- box_cards45 --><div class="box_cards45 font_spc">Powered by &copy;<strong>PowerFortunes.com</strong></div><!-- box_cards45 -->';
}
$credits .= '</div><!-- end of box_pfcard -->';
	}//if
}//else
print_r($frm_cont.$credits);
?>
</div>
<!-- End of Code for weekly Zodiac Signs -->

<?php   
add_option( 'power_fortune_telling_cards_plugin_option', 'cards' );
}// end of func

// shortcode
add_shortcode( 'weekly_fortune_telling_cards', 'power_weekly_cards_plugin' );

/* ------------- */
/* Plugin Deactivation */
/* ------------- */
function weekly_cards_deactive() {
delete_option('rewrite_rules');
}
?>