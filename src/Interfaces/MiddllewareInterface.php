<?php
    use Models\User;

    interface Middleware {
        public function CheckRedirect(User $user, int $status_page): bool;
    }

    // interface for Middleware cheking
    // declaration of redirect function for middleware - CheckRedirect(User $user, int $status_page): bool;
?>
