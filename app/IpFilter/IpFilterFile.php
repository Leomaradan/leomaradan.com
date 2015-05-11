<?php

namespace App\IpFilter;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use File;

/*******
 * Part of this code come from Sebastien Sauvage 
 * Sources here : http://sebsauvage.net/paste/?36dbd6c6be607e0c#M5uR8ixXo5rXBpXx32gOATLraHPffhBJEeqiDl1dMhs
 * http://sebsauvage.net/links/?kO4Krg
 *******/


class IpFilterFile implements IpFilterInterface {

	private $app;
	private $files;
	private $path;

	private $BanAfter;
	private $BanDuration;
   
   	private $ipban;

   	public function __construct(Application $app)
	{
		//dd($app);
		$this->app = $app;    

		$this->path = $this->app['config']['ipfilter.stores.file.path'];

		$this->files = $this->app['files'];

    	$this->BanAfter = $this->app['config']['ipfilter.ban.attempt'];
    	$this->BanDuration = $this->app['config']['ipfilter.ban.duration'];


    	$this->createDirectory($this->path);


		if (!is_file($this->getFilname())) 
		{
			$this->WriteBanFile(array('FAILURES'=>array(),'BANS'=>array()));
		}

		include $this->getFilname();        
    }


    private function getFilname()
    {
    	return $this->getDir() . '/ipfilter.php' ;
    }

    private function getDir()
    {
    	return $this->path;
    }

	protected function createDirectory($path)
	{
		try
		{
			$result = $this->files->makeDirectory(dirname($path), 0777, true, true);
			//dd($result);

		}
		catch (Exception $e)
		{
			dd($e);
		}
	}

    /*public static function refreshPermissions($userid, $force=false) {

        if(isset(Session::has('permschecked.'.$userid)) && !$force) {
            // No refresh needed
            return;
        }

        $perms = Modeles::getModel('account', 'permissions');

        $liste_perms = $perms->getPermissions($userid);

        unset($_SESSION['token']['admin']);
        unset($_SESSION['token']['perms']);

        if(is_array($liste_perms)) {

            foreach ($liste_perms as $line) {

                if($line[PermissionsModel::PERM_FIELD] != null) {
                    $key = $line[PermissionsModel::PERM_FIELD];

                    $_SESSION['token']['perms'][$key] = true;

                    if($key == 'ADMIN') {
                        $_SESSION['token']['admin'] = true;
                    }
                }

                $isadmin = $line[PermissionsModel::ADMIN_FIELD];

                if($isadmin != null && $isadmin == true) {
                     $_SESSION['token']['admin'] = true;
                }
            }


            $_SESSION['permschecked'][$userid] = true;
        }
    }*/

    // ------------------------------------------------------------------------------------------
    // Brute force protection system
    // Several consecutive failed logins will ban the IP address for 30 minutes.

    // Signal a failed login. Will ban the IP if too many failures:
    public function fail($ip)
    {
        //$ip=$_SERVER["REMOTE_ADDR"]; 
        $gb=$this->ipban;

        if (!isset($gb['FAILURES'][$ip])) {
        	$gb['FAILURES'][$ip]=0;
        } 

        $gb['FAILURES'][$ip]++;

        if ($gb['FAILURES'][$ip]>($this->BanAfter - 1))
        {
            $gb['BANS'][$ip]=time()+$this->BanDuration;
            Log::warning('IP address banned');
        }

        $this->ipban = $gb;

        $this->WriteBanFile($gb);
    }


    // Signals a successful login. Resets failed login counter.
    public function release($ip)
    {
        //$ip=$_SERVER["REMOTE_ADDR"]; 
        $gb=$this->ipban;

        unset($gb['FAILURES'][$ip]); 
        unset($gb['BANS'][$ip]);

        $this->ipban = $gb;

        $this->WriteBanFile($gb);
        Log::info('Login ok.');
    }

    // Checks if the user CAN login. If 'true', the user can try to login.
    public function check($ip)
    {
        //$ip = $_SERVER["REMOTE_ADDR"]; 
        $gb = $this->ipban;

        if (isset($gb['BANS'][$ip]))
        {
            // User is banned. Check if the ban has expired:
            if ($gb['BANS'][$ip]<=time())
            { // Ban expired, user can try to login again.
                Log::info('Ban lifted.');
                unset($gb['FAILURES'][$ip]); 
                unset($gb['BANS'][$ip]);
                $this->WriteBanFile($gb);
                return true; // Ban has expired, user can login.
            }
            return false; // User is banned.
        }
        return true; // User is not banned.
    }    

    private function WriteBanFile($content) {
		File::put($this->getFilname(), "<?php\n return ".var_export($content,true).";\n?>");
    }
}
