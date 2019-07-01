<footer class="main-footer">
    <div class="row">
        <div class="col-lg-12">

            <hr/>
            <!-- Small footer boxes -->
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <ul class="list-unstyled">
                        <li><a href="http://company.cyberspace-networks.com/home">Company</a></li>
                        <li><a href="http://webmaster.cyberspace-networks.com/home">Webmaster</a></li>
                        <li><a href="http://developer.cyberspace-networks.com/home">Developer</a></li>
                    </ul>
                </div>
                <!-- ./col -->          
                <div class="col-lg-3 col-xs-6">
                    <ul class="list-unstyled">
                        <li><a href="./imprint" onclick="pageTracker._link(this.href);
                                return false;"><?= __("Imprint") ?></a></li>
                        <li><a href="./terms" onclick="pageTracker._link(this.href);
                                return false;"><?= __("Terms") ?></a></li>
                        <li><a href="./license" onclick="pageTracker._link(this.href);
                                return false;"><?= __("License") ?></a></li>
                        <li><a href="./accounts" onclick="pageTracker._link(this.href);
                                return false;"><?= __("Accounts") ?></a></li>
                    </ul>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <ul class="list-unstyled">
                        <li><a href="./platform" onclick="pageTracker._link(this.href);
                                return false;"><?= __("Platform") ?></a></li>
                        <li><a href="./features" onclick="pageTracker._link(this.href);
                                return false;"><?= __("Features") ?></a></li>
                        <li><a href="./faq" onclick="pageTracker._link(this.href);
                                return false;"><?= __("FAQ") ?></a></li>
                        <li><a href="./wiki" onclick="pageTracker._link(this.href);
                                return false;"><?= __("Wiki") ?></a></li>
                        <!--
                        <li><a href="./demo" onclick="pageTracker._link(this.href);
                                return false;"><?= __("Demo") ?></a></li>
                        -->
                    </ul>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <ul class="list-unstyled">
                        <div id="social">
                            <div id="facebook">
                                <?php include("web/Themes/Default/ext/facebook/facebook_like_button.php"); ?>
                            </div>
                            <div id="googleplus" style="margin-top: 5px">
                                <div class="g-follow" data-href="https://plus.google.com/105566778697915038031" data-rel="author"></div>
                            </div>
                            <div id="twitter">
                                <a href="https://twitter.com/CyberspaceNet" class="twitter-follow-button" data-show-count="false" data-show-screen-name="true">Follow @CyberspaceNet</a>
                                <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.cyberspace-networks.com" data-via="CyberspaceNet">Tweet</a>
                            </div>                            
                        </div>
                        <hr/>
                        <div id="github">
                            <iframe id="gh-fork" src="//ghbtns.com/github-btn.html?user=Cyberspace-Networks&repo=CoreSystem&type=fork" allowtransparency="true" frameborder="0" scrolling="0" width="53" height="20"></iframe>
                            <iframe id="gh-star" src="//ghbtns.com/github-btn.html?user=Cyberspace-Networks&repo=CoreSystem&type=watch&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="110" height="20"></iframe>
                        </div>
                        <div id="sourceforge">
                            <a href="https://sourceforge.net/projects/coresystem/files/latest/download" rel="nofollow"><img alt="Download CoreSystem" src="https://a.fsdn.com/con/app/sf-download-button"></a>
                        </div>
                        <hr/>
                        <div id="rss">
                            <a href="./feed.php?type=all" class="btn btn-default btn-xs"><i class="fa fa-rss"></i> RSS</a>
                        </div>
                        <hr/>
                        <div id="feedburner">
                            <a href="http://feeds.feedburner.com/Cyberspace-Networks"><img src="http://feeds.feedburner.com/~fc/Cyberspace-Networks?bg=99CCFF&amp;fg=444444&amp;anim=0" height="26" width="88" style="border:0" alt="" /></a>
                        </div>
                    </ul>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->    
            <hr/>
            <ul class="list-unstyled">
                <li class="pull-right"><a href="#top">Back to top</a></li>
                <!--
                <li><a href="./help/#api">API</a></li>
                <li><a href="./help/#support">Support</a></li>
                <li><a href="./vod.php" onclick="pageTracker._link(this.href);
                        return false;"><?= __("VOD") ?></a></li>
                -->
            </ul>

            <p>The <a href="https://github.com/Cyberspace-Networks/CoreSystem" rel="nofollow">CoreSystem</a> <?= get_svn_version() ?> is maintained by <a href="http://www.cyberspace-networks.com" rel="nofollow">Cyberspace-Networks</a>. Contact us at <a href="mailto:contact@cyberspace-networks.com">contact@cyberspace-networks.com</a>.</p>
            <p>Code released under the <a href="https://github.com/Cyberspace-Networks/CoreSystem/blob/master/LICENSE">GNU GENERAL PUBLIC LICENSE</a>.</p>
            <p>Theme based on <a href="http://getbootstrap.com" rel="nofollow">Bootstrap</a>, <a href="https://github.com/thomaspark/bootswatch">Bootswatch</a> and <a href="http://almsaeedstudio.com">AdminLTE</a>. Icons from <a href="http://fortawesome.github.io/Font-Awesome/" rel="nofollow">Font Awesome</a>. Web fonts from <a href="http://www.google.com/webfonts" rel="nofollow">Google</a>.</p>
            <p><?= sprintf(__("&copy; %s Cyberspace-Networks"), date('Y')) ?></p>
        </div>
    </div>
</footer>
