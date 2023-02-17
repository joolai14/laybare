<!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
			
			<li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-building"></i>
                    <span>Company Profile</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <div class="bg-white py-2 collapse-inner rounded">							<h6 class="collapse-header">Company Profile:</h6>							<a class="collapse-item" href="company_profile.php?action=history">Profile</a>							<a class="collapse-item" href="company_profile.php?action=policy">Policy</a>							<a class="collapse-item" href="company_profile.php?action=chart">Organizational Chart</a>						</div>
                </div>
            </li>
			
			<li class="nav-item">
                <a class="nav-link" href="my_daily_reports.php">
                    <i class="fas fa-fw fa-tasks"></i>
                    <span>My Daily Report</span></a>
            </li>
			
			<li class="nav-item">
                <a class="nav-link" href="my_time_logs.php">
                    <i class="fas fa-fw fa-clock"></i>
                    <span>My Time Logs</span></a>
            </li>
			
			<li class="nav-item">
                <a class="nav-link" href="myleave.php">
                    <i class="fas fa-fw fa-umbrella"></i>
                    <span>Leaves</span></a>
            </li>
			
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Admin Tools
            </div>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="employees.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Employees</span></a>
            </li>

			<li class="nav-item">
                <a class="nav-link" href="feeds.php">
                    <i class="fas fa-fw fa-list"></i>
                    <span>Feed Management</span></a>
            </li>
			
			<li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLeaves"
                    aria-expanded="true" aria-controls="collapseLeaves">
                    <i class="fas fa-fw fa-umbrella"></i>
                    <span>Leave Management</span>
                </a>
                <div id="collapseLeaves" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Leave Management:</h6>
                        <a class="collapse-item" href="leaves_management.php">Leave Reporting</a>
                        <a class="collapse-item" href="leave_filing.php">File Employee Leave</a>
                        <a class="collapse-item" href="leaves_report_all.php?action=summary">Summary</a>
                        <a class="collapse-item" href="leaves_report_all.php?action=incoming">Incoming Leaving</a>
                        <a class="collapse-item" href="leaves_report_all.php?action=notapproved">Not Yet Approved Leave</a>
                    </div>
                </div>
            </li>
			
			<li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInterns"
                    aria-expanded="true" aria-controls="collapseInterns">
                    <i class="fas fa-fw fa-user-friends"></i>
                    <span>Interns</span>
                </a>
                <div id="collapseInterns" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Interns:</h6>
                        <a class="collapse-item" href="interns.php">Interns</a>
                        <a class="collapse-item" href="timelogs_report_intern.php">Time Logs</a>
                        <a class="collapse-item" href="intern_daily_reports.php">Daily Report</a>
                    </div>
                </div>
            </li>
			
			<li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTools"
                    aria-expanded="true" aria-controls="collapseTools">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Tools</span>
                </a>
                <div id="collapseTools" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Tools:</h6>
                        <a class="collapse-item" href="departments.php">Departments</a>
                        <a class="collapse-item" href="reminders.php">Reminders</a>
                        <a class="collapse-item" href="leave_types.php">Leave Types</a>
                        <a class="collapse-item" href="requirement_lists.php">Requirements</a>
                        <a class="collapse-item" href="users.php">User Management</a>
						<a class="collapse-item" href="notes.php"><i class="fas fa-fw fa-tasks"></i><span> Notes</span></a>
                    </div>
                </div>
            </li>
			
			<li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReports"
                    aria-expanded="true" aria-controls="collapseReports">
                    <i class="fas fa-fw fa-print"></i>
                    <span>Reports</span>
                </a>
                <div id="collapseReports" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Reports:</h6>
                        <a class="collapse-item" href="employees.php"><i class="fas fa-fw fa-users"></i><span> Employees</span></a>
                        <a class="collapse-item" href="daily_reports.php"><i class="fas fa-fw fa-tasks"></i><span> Daily Reporting</span></a>
                        <a class="collapse-item" href="timelogs_report.php"><i class="fas fa-fw fa-clock"></i><span> Time Logs</span></a>
                        
                    </div>
                </div>
            </li>