<?php
/**
 * Class PageEditor_View_Modules
 *
 * @author	support@page-editor.com
 * @license GPL 3.0 (https://www.gnu.org/licenses/gpl-3.0)
 */
if ( ! class_exists( 'PageEditor_View_Modules' ) ) {
	class PageEditor_View_Modules extends PageEditor_View_Template {


		public static function current_url() {
			return 'admin.php?page=pe-modules';
		}


		public static function content() {
      $module_manager = PageEditor_WordPressPlugin::module_manager();
      $modules = $module_manager->all_modules();
		?>
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>Module Id</th>
						<th>Version</th>
						<th>Stability</th>
            <th>Description</th>
						<th>Author</th>
						<th>License</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ( $modules as $module ): ?>
					<tr>
						<td><?php echo $module->id ?></td>
						<td><?php echo $module->version ?></td>
						<td title="<?php echo $module->stability_description() ?>">
              <?php echo $module->stability ?>
            </td>
            <td><?php echo $module->description ?></td>
            <td>
              <?php if ( $module->author_url ): ?>
                <a target="_blank" href="<?php echo $module->author_url ?>">
                  <?php echo $module->author_name ?>
                </a>
              <?php else: ?>
                <?php echo $module->author_name ?>
              <?php endif; ?>
            </td>
            <td>
              <?php if ( $module->license_url ): ?>
                <a target="_blank" href="<?php echo $module->license_url ?>"><?php echo $module->license_name ?></a>
              <?php else: ?>
                <?php echo $module->license_name ?>
              <?php endif; ?>
            </td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		<?php
		}


	}
}