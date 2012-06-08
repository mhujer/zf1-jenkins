<?php
require_once "phing/Task.php";
class ZfPhpUnitTask extends Task
{
    protected $phpunitExecutable = 'phpunit34';
    protected $testsDir = 'i:\xampp\zf\tests\\';
    protected $testsReportDir = 'i:\Jenkins\data\jobs\zf1-tests\workspace\\';
    
    /**
     * The init method: Do init steps.
     */
    public function init ()
    {
        // nothing to do here
    }
    
    /**
     * The main entry point method.
     */
    public function main ()
    {
        chdir($this->testsDir);
        // locate all tests
        $files = glob('{Zend/*/AllTests.php,Zend/*Test.php}', GLOB_BRACE);
        sort($files);
        
        // run through phpunit
        while (list (, $file) = each($files)) {
            $reportFilename = str_replace('/', '-', $file);
            $reportFilename = str_replace('php', 'xml', $reportFilename);
            echo "Executing {$file} -> {$reportFilename}" . PHP_EOL;
            shell_exec($this->phpunitExecutable . ' --stderr -d memory_limit=-1 --log-junit ' . $this->testsReportDir . $reportFilename . ' ' . escapeshellarg($file));
            echo PHP_EOL;
        }
    }
}
?>