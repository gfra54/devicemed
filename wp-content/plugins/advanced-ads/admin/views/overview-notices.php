<?php if ( Advanced_Ads_Ad_Health_Notices::get_instance()->has_notices_by_type( 'problem' ) ) :

	?><h3><?php esc_attr_e( 'Problems', 'advanceda-ads' ); ?></h3>
	<?php
	Advanced_Ads_Ad_Health_Notices::get_instance()->display_problems();

endif;
if ( Advanced_Ads_Ad_Health_Notices::get_instance()->has_notices_by_type( 'notice' ) ) :

	?><h3><?php
	esc_attr_e( 'Notifications', 'advanceda-ads' );
	?>
    </h3>
	<?php

	Advanced_Ads_Ad_Health_Notices::get_instance()->display_notices();

endif;
$ignored_count = count( Advanced_Ads_Ad_Health_Notices::get_instance()->ignore );
?>
    <p class="adsvads-ad-health-notices-show-hidden" <?php echo ! $ignored_count ? 'style="display: none;"' : ''; ?>><?php
		printf(
// translators: %s includes a number and markup like <span class="count">6</span>.
			__( 'Show %s hidden', 'advanced-ads' ), '<span class="count">' . $ignored_count . '</span>' );
		?>&nbsp;
        <button type="button"><span class="dashicons dashicons-visibility"></span></button>
    </p>
<?php

if ( Advanced_Ads_Ad_Health_Notices::has_visible_problems() ) {
	include ADVADS_BASE_PATH . 'admin/views/support-callout.php';
}