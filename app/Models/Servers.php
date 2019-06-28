<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servers extends Model
{
    protected $fillable = [
    	'ip',
	    'port',
	    'user',
	    'password',
	    'domain',
	    'active',
	    'sftp_root_path',
	    'sftp_status' // 0 not run test, 1=> connected to server, 2=> sftp error
    ];
	
		public function getServers($id=false)
		{
			if ($id) {
				return $this->where('id', '=', $id)->first();
			} else {
				return $this->get();
			}
		}
	
		public function createServer($request)
		{
			$input = ([
				'ip' => $request['ip'] ? $request['ip'] : NULL,
				'port' => $request['port'] ? $request['port'] : NULL,
				'user' => $request['user'] ? $request['user'] : NULL,
				'password' => $request['password'] ? $request['password'] : NULL,
				'sftp_root_path' => $request['basePath'] ? $request['basePath'] : NULL,
				'domain' => $request['domain'] ? $request['domain'] : NULL,
				'active' =>  $request['active'] && $request['active'] == 'true' ? 1 : 0,
			]);
			$input = array_filter($input, 'strlen');
			return $this->create($input);
		}
		
		public function updateServer($request)
		{
			$input = ([
				'ip' => $request['ip'] ? $request['ip'] : NULL,
				'port' => $request['port'] ? $request['port'] : NULL,
				'user' => $request['user'] ? $request['user'] : NULL,
				'password' => $request['password'] ? $request['password'] : NULL,
				'domain' => $request['domain'] ? $request['domain'] : NULL,
				'sftp_root_path' => $request['basePath'] ? $request['basePath'] : NULL,
				'active' =>  $request['active'] && $request['active'] == 'true' ? 1 : 0,
			]);
			$input = array_filter($input, 'strlen');
			return $this->where('id', '=', $request['server_id'])->update($input);
		}
		
		public function deleteServer($id)
		{
			return $this->where('id', '=', $id)->delete();
		}
}
