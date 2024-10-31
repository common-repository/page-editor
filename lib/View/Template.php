<?php
/**
 * Class PageEditor_View_Template
 *
 * @author	support@page-editor.com
 * @license GPL 3.0 (https://www.gnu.org/licenses/gpl-3.0)
 */
if ( ! class_exists( 'PageEditor_View_Template' ) ) {
	abstract class PageEditor_View_Template
    implements PageEditor_View_TemplateViewProvider {


		public static function tabs() {
			return [
				'admin.php?page=pe-settings' => 'Settings',
				'admin.php?page=pe-modules'  => 'Modules',
				'admin.php?page=pe-about'    => 'About',
			];
		}


		public static function render() {
		?>
			<div class="wrap page-editor">

				<h1><?php echo PageEditor_WordPress::admin_page_title(); ?></h1>

				<?php $tabs = self::tabs() ?>

				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<?php foreach ( $tabs as $url => $title ): ?>
					<li role="presentation"<?php if ( static::current_url() == $url ): ?> class="active"<?php endif; ?>>
						<a href="<?php echo $url; ?>"><?php echo __( $title, 'page-editor' ) ?></a>
					</li>
					<?php endforeach; ?>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content">
					<?php static::content(); ?>
				</div>

			</div>
		<?php
		}


	}
}