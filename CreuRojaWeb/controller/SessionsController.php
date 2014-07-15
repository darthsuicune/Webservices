<?php
interface SessionsController {
	const USER = "user";
	const LANGUAGE = "language";
	public function createSession(User $user);
	public function destroySession();
	public function setLanguage($language);
}