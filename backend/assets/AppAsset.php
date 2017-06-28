<?php

namespace backend\assets;

use yii\helpers\Url;
use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    const STUDENT_INDEX = '/admin/student/index';

    public $baseUrl = '@web';
    public $sourcePath = '@bower';
    public $css = [
        'bootstrap/dist/css/bootstrap.min.css',
        'font-awesome/css/font-awesome.min.css',
        'iCheck/skins/flat/green.css',
        'bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css',
        'switchery/dist/switchery.min.css'
    ];
    public $js = [
        'jquery/dist/jquery.min.js',
        'jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js',
        'bootstrap/dist/js/bootstrap.min.js',
        'switchery/dist/switchery.min.js',
        'fastclick/lib/fastclick.js',
        'nprogress/nprogress.js',
        'dropzone/dist/min/dropzone.min.js',
        'Chart.js/dist/Chart.min.js',
        'Chart.js/dist/Chart.min.js',
        'gauge.js/dist/gauge.min.js',
        'bootstrap-progressbar/bootstrap-progressbar.min.js',
        'iCheck/icheck.min.js',
        'skycons/skycons.js',
        'Flot/jquery.flot.js',
        'Flot/jquery.flot.pie.js',
        'Flot/jquery.flot.time.js',
        'Flot/jquery.flot.stack.js',
        'Flot/jquery.flot.resize.js'
    ];

    public function init()
    {
        parent::init();

        // include only on student all page
        if (Url::current() == self::STUDENT_INDEX) {
            $this->css[] = 'datatables.net-bs/css/dataTables.bootstrap.min.css';
            $this->js[] = 'datatables.net/js/jquery.dataTables.min.js';
            $this->js[] = 'datatables.net-bs/js/dataTables.bootstrap.min.js';
            $this->js[] = 'datatables.net-buttons/js/dataTables.buttons.min.js';
            $this->css[] = 'datatables.net-buttons-bs/css/buttons.bootstrap.min.css';
            $this->js[] = 'datatables.net-buttons-bs/js/buttons.bootstrap.min.js';

            $this->js[] = 'datatables.net-responsive/js/dataTables.responsive.min.js';

            $this->css[] = 'datatables.net-responsive-bs/css/responsive.bootstrap.min.css';
            $this->js[] = 'datatables.net-responsive-bs/js/responsive.bootstrap.js';
        }
    }
}
