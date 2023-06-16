<!--Footer-->
<footer class="hero-foot gray-bg exam-foot">
    <nav class="tabs is-right">
        <div class="container">
            <ul>
                <li class="help">
                    <a class="orange-text font-weight-700 font-size-12 has-text-centered" href="{{ action('Exams@showHelp', $course->id) }}" target="_blank">
                        <img src="/public/img/settings/help.png" alt="Help" class="image is-32x32">
                        Help
                    </a>
                </li>
                <li class="margin-right-50">
                    <a id="launch-live-chat" class="orange-text font-weight-700 font-size-12 has-text-centered">
                        <span class="white-text">LIVE CHAT WITH CBEKIT TEAM</span>
                    </a>
                </li>
                <li class="flag margin-right-50">
                    <a class="orange-text font-weight-700 font-size-12 has-text-centered">
                        <img src="/public/img/settings/flag.png" alt="Flag" class="image is-32x32">
                        Flag
                    </a>
                </li>
                <li class="unflag hidden margin-right-50">
                    <a class="orange-text font-weight-700 font-size-12 has-text-centered">
                        <img src="/public/img/settings/unflag.png" alt="UnFlag" class="image is-32x32">
                        Remove Flag
                    </a>
                </li>
                <li>
                    <a class="orange-text font-weight-700 font-size-12 has-text-centered"  prev-question >
                        <img src="/public/img/settings/prev.png" alt="Previous" class="image is-32x32">
                        Previous
                    </a>
                </li>
                <li>
                    <a class="orange-text font-weight-700 font-size-12 has-text-centered"  next-question >
                        <img src="/public/img/settings/next.png" alt="Previous" class="image is-32x32">
                        Next
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</footer>
<!--End Footer-->