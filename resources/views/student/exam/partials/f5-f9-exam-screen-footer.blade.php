<!--Footer-->
<footer class="hero-foot offwhite2-bg exam-foot">
    <nav class="tabs is-right">
        <div class="container">
            <ul>
                <li class="help">
                    <a href="#" class="black-text font-weight-700 font-size-12 has-text-centered" data-toggle="modal" data-target="#help-and-formulae">
                        <i class="fa fa-question-circle-o"></i>
                        Help & Formulae Sheet
                    </a>
                </li>
                <!--<li class="flag margin-right-50">-->
                <!--    <a class="orange-text font-weight-700 font-size-12 has-text-centered" data-flag="{{ $questions[$i-1]['id'] }}">-->
                <!--        <img src="/public/img/settings/flag.png" alt="Flag" class="image is-32x32">-->
                <!--        Flag-->
                <!--    </a>-->
                <!--</li>-->
                <!--<li class="unflag hidden margin-right-50">-->
                <!--    <a class="orange-text font-weight-700 font-size-12 has-text-centered" data-flag="{{ $questions[$i-1]['id'] }}">-->
                <!--        <img src="/public/img/settings/unflag.png" alt="UnFlag" class="image is-32x32">-->
                <!--        Remove Flag-->
                <!--    </a>-->
                <!--</li>-->
                @if( $i > 1 )
                <li>
                    <a class="orange-text font-weight-700 font-size-12 has-text-centered prev-exam"  data-window_toggler="[{{ $i + 100 - 1 }},{{ $i + 100 }}]">
                        <span class="prev-icon"></span>
                        Previous
                    </a>
                </li>
                @else
                <li>
                    <a class="orange-text font-weight-700 font-size-12 has-text-centered prev-exam"  data-window_toggler="[]">
                        <span class="prev-icon"></span>
                        Previous
                    </a>
                </li>
                @endif
                
                <li>
                    <a class="orange-text font-weight-700 font-size-12 has-text-centered" data-toggle="modal" data-target="#question-navigator">
                        <span class="navigation-icon"></span>
                        &nbsp;Navigator
                    </a>
                </li>
                
                @if( $i < count( $questions ) )
                <li>
                    <a class="black-text font-weight-700 font-size-12 has-text-centered next-exam"  data-window_toggler="[ {{ $i + 100 }} , {{ $i + 100 + 1 }} ]">
                        Next
                        <span class="next-icon"></span>
                    </a>
                </li>
                @else
                <li>
                    <a class="black-text font-weight-700 font-size-12 has-text-centered next-exam"  data-window_toggler="[]">
                        Next
                        <span class="next-icon"></span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </nav>
</footer>
<!--End Footer-->