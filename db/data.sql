
--
-- Dumping data for table `user_role`
--

INSERT INTO `user_roles` (`role_id`, `role_name`) VALUES
(1, 'Super Admin'),
(2, 'Admin');

--
-- Dumping data for table `user`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_full_name`, `user_password`, `user_email`, `user_pob`, `user_dob`, `user_input_date`, `user_last_update`, `user_role_role_id`, `user_is_deleted`) VALUES
(1, 'admin', 'Admin', 'f99aecef3d12e02dcbb6260bbdd35189c89e6e73', 'admin@example.com', 'Jakarta', '2015-07-30 04:32:54', '2015-07-30 04:32:54', '2015-07-30 04:32:54', 1, 0);
