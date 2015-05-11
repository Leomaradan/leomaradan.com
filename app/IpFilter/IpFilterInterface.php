<?php

namespace App\IpFilter;

interface IpFilterInterface {
	public function fail($ip);
	public function release($ip);
	public function check($ip);

}