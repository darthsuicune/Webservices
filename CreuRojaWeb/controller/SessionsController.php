<?php
interface SessionsController {
	const USER_OBJECT = "user";
	public function createSession(User $user);
	public function destroySession();
}