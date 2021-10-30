<ul class="nav nav-tabs customtab" role="tablist">
                <li class="nav-item">
                     <?php
                  echo $this->Html->link(
                        __(
                            $this->Html->tag("span", "Current Employess")
                        ),
                        ['action' => 'index'],
                        [
                            'escape' => false,
                            'data-toggle' => 'tooltip',
                            'data-original-title' => 'View',
                            'class' => 'nav-link',
                            'role'  => 'tab',
                            'aria-selected' => 'true',
                        ]
                    );
                ?>
                </li>
                <li class="nav-item">
                     <?php
                  echo $this->Html->link(
                        __(
                            $this->Html->tag("span", "Inactive Employess")
                        ),
                        ['action' => 'inactive'],
                        [
                            'escape' => false,
                            'data-toggle' => 'tooltip',
                            'data-original-title' => 'View',
                            'class' => 'nav-link',
                            'role'  => 'tab',
                            'aria-selected' => 'false',
                        ]
                    );
                ?>
                </li>
</ul>
