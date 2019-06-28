<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Servers;
use Config;
use Illuminate\Http\Request;
use Log;

class ServerController extends Controller
{
	function __construct()
	{
		$this->servers = new Servers();
	}
	
	public function index(Request $request)
	{
		return view('admin.servers.index',[
			'servers' => $this->servers->getServers()
		]);
	}
	
	public function addServer(Request $request)
	{
		return view('admin.servers.add');
	}
	
	public function postAddServer(Request $request)
	{
		$data = $this->servers->createServer($request);
		self::checkSFTPConnections($data);
		return redirect('/admin/servers');
	}
	
	public function getServer($serverId)
	{
		return view('admin.servers.edit',[
			'servers' => $this->servers->getServers($serverId)
		]);
	}
	
	public function updateServer(Request $request)
	{
		$res = $this->servers->updateServer($request);
		return redirect('/admin/servers');
	}
	
	public function deleteServers($id)
	{
		$this->servers->deleteServer($id);
		return redirect('/admin/servers');
	}
	
	public function getCheckSFTPConnections(Request $request)
	{
			$data = $request->id;
			$data = $this->servers->getServers($data);
			return (self::checkSFTPConnections($data));
	}
	
	public function checkSFTPConnections($data)
	{
		try {
			Config::set('remote.connections.production.host', $data->ip);
			Config::set('remote.connections.production.username', $data->user);
			Config::set('remote.connections.production.password', $data->password);
			(\SSH::into('production')->put(
				public_path('assets/test.txt'),
				$data->sftp_root_path.'test.txt'
			));
			$this->servers->where('id', '=', $data->id)->update([
				'sftp_status' => 1
			]);
			return collect([
				'status' => true
			]);
		} catch (\Exception $e) {
			Log::info('********************* Server SFTP ERROR *********************');
			Log::info('remote.connections.production.host : ' . $data->ip);
			Log::info('remote.connections.production.username : ' . $data->user);
			Log::info('remote.connections.production.password : ' . $data->password);
			Log::info('********************* Server SFTP ERROR *********************');
			$this->servers->where('id', '=', $data->id)->update([
				'sftp_status' => 2
			]);
			return collect([
				'status' => false
			]);
		}
	}
	
}
