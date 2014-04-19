<?php
interface SessionsController {
	public function createSession(User $user);
	public function destroySession();
}