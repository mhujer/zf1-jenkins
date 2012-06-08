<?php
require_once "phing/Task.php";
class ZfPhpUnitTask extends Task
{
    protected $phpunitExecutable = null;
    protected $testsDir = null;
    protected $testsReportDir = null;
    
    public function setPhpunitexecutable($phpunitExecutable)
    {
    	$this->phpunitExecutable = $phpunitExecutable;
    }
    
    public function setTestsdir($testsDir)
    {
    	$this->testsDir = $testsDir;
    }
    
    public function setTestsreportdir($testsReportDir)
    {
    	$this->testsReportDir = $testsReportDir;
    }
    
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