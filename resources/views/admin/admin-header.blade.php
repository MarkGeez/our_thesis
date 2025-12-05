 <nav class="main-nav--bg" >
                <div class="container main-nav">
                    <div class="main-nav-start" >
                        <div style="display:inline-block; margin-right:12px;">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b1/Bagong_Pilipinas_logo.png/330px-Bagong_Pilipinas_logo.png"
                                alt="logo" style="width:50px; height:auto; display:block;">
                        </div>
                    </div>
                    <div class="main-nav-end">
                        <button class="sidebar-toggle transparent-btn" title="Menu" type="button">
                            <span class="sr-only">Toggle menu</span>
                            <span class="icon menu-toggle--gray" aria-hidden="true"></span>
                        </button>

                        <div class="nav-user-wrapper">
                            <button href="##" class="nav-user-btn dropdown-btn" title="My profile" type="button">
                                <span class="sr-only">My profile</span>
                                <span class="nav-user-img">
                                    <picture>
                                        <source srcset="./img/avatar/avatar-illustrated-02.webp" type="image/webp">
                                        <img src="./img/avatar/avatar-illustrated-02.png" alt="User name">
                                    </picture>
                                </span>
                            </button>
                            <ul class="users-item-dropdown nav-user-dropdown dropdown">
                                <li class="user-info text-center">
                                    <h3 class="user-name mb-2">{{ ucfirst(auth()->user()->firstName) }}</h3>
                                    <p class="text-secondary user-role text-muted small">Admin</p>
                                </li>
                                <hr>
                                <li>
                                    <a href="##">
                                        <i data-feather="user" aria-hidden="true"></i>
                                        <span>Profile</span>
                                    </a>
                                </li>

                                <li>
                                    <a class="danger" href="##">
                                        <i data-feather="log-out" aria-hidden="true"></i>
                                        <span>Log out</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>