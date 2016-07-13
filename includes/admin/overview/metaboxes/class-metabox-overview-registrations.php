<?php
/**
 * The AffWP_Meta_Box_Overview_Registrations class.
 *
 * This class extends AffWP_Meta_Box_Base, and defines
 * a meta box which displays recent affiliate registrations.
 *
 * @since  1.9
 * @see    AffWP_Meta_Box_Base
 */
class AffWP_Meta_Box_Overview_Registrations extends AffWP_Meta_Box_Base {

    /**
     * The id of the meta box. Must be unique.
     *
     * @access  public
     * @since   1.9
     */
    public $meta_box_id = 'overview-registrations';

    /**
     * The position in which the meta box will be loaded
     * Either 'normal', 'side', or 'advanced'.
     *
     * @access  public
     * @var     $context
     * @since   1.9
     */
    public $context = 'primary';

    /**
     * Initialize.
     *
     * Define the meta box name,
     * and the action on which to hook the meta box here.
     *
     * Example:
     *
     * $this->action        = 'affwp_overview_meta_boxes';
     * $this->meta_box_name = __( 'Name of the meta box', 'affiliate-wp' );
     *
     * @access  public
     * @return  void
     * @since   1.9
     */
    public function init() {
        $this->action        = 'affwp_overview_meta_boxes';
        $this->meta_box_name = __( 'Latest Affiliate Registrations', 'affiliate-wp' );
    }

    /**
     * Displays the content of the metabox
     *
     * @return mixed content  The metabox content
     * @since  1.9
     */
    public function content() { ?>

        <?php $affiliates = affiliate_wp()->affiliates->get_affiliates( apply_filters( 'affwp_overview_latest_affiliate_registrations', array( 'number' => 5 ) ) ); ?>
        <table class="affwp_table">

            <thead>

                <tr>
                    <th><?php _e( 'Affiliate', 'affiliate-wp' ); ?></th>
                    <th><?php _e( 'Status', 'affiliate-wp' ); ?></th>
                    <th><?php _e( 'Actions', 'affiliate-wp' ); ?></th>
                </tr>

            </thead>

            <tbody>
                <?php if( $affiliates ) : ?>
                    <?php foreach( $affiliates as $affiliate  ) : ?>
                        <tr>
                            <td><?php echo affiliate_wp()->affiliates->get_affiliate_name( $affiliate->affiliate_id ); ?></td>
                            <td><?php echo affwp_get_affiliate_status_label( $affiliate ); ?></td>
                            <td>
                                <?php
                                if( 'pending' == $affiliate->status ) {
                                    $review_url = admin_url( 'admin.php?page=affiliate-wp-affiliates&action=review_affiliate&affiliate_id=' . $affiliate->affiliate_id );
                                    echo '<a href="' . esc_url( $review_url ) . '">' . __( 'Review', 'affiliate-wp' ) . '</a>';
                                } else {
                                    $affiliate_report_url = admin_url( 'admin.php?page=affiliate-wp-affiliates&action=view_affiliate&affiliate_id=' . $affiliate->affiliate_id );
                                    echo '<a href="' . esc_url( $affiliate_report_url ) . '">' . __( 'View Report', 'affiliate-wp' ) . '</a>';
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="3"><?php _e( 'No affiliate registrations yet', 'affiliate-wp' ); ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>

        </table>
<?php }
}

new AffWP_Meta_Box_Overview_Registrations;
