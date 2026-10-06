<div class="account-content-grid">
    <div class="container">
        <div class="luxury-card security-card">
            <div class="luxury-card-head">
                <div class="head-icon">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div>
                    <h2>Change Password</h2>
                    <p>Ensure your account remains safe with a strong, unique password</p>
                </div>
            </div>

            <form class="luxury-form" id="MySettingsForm" action="javascript:;" method="post" autocomplete="off">
                @csrf

                <div class="alert alert-success print-success-msg" style="display:none">
                    <ul></ul>
                </div>

                <div class="luxury-field">
                    <label for="current_password">Current Password <span>*</span></label>
                    <div class="field-with-icon password-toggle-wrap">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Enter existing password">
                        <button type="button" class="pass-toggle-btn" onclick="togglePassVisibility('current_password', this);" title="Toggle visibility">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                    <p class="err text-center" id="ChangePwd-current_password" style="display: none;"></p>
                </div>

                <div class="luxury-field mt-3">
                    <label for="password">New Password <span>*</span></label>
                    <div class="field-with-icon password-toggle-wrap">
                        <i class="fa-solid fa-key"></i>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Create a strong password" oninput="checkStrength(this.value);">
                        <button type="button" class="pass-toggle-btn" onclick="togglePassVisibility('password', this);" title="Toggle visibility">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                    <!-- PASSWORD STRENGTH BAR -->
                    <div class="strength-meter mt-2">
                        <div class="strength-bar" id="strengthBar"></div>
                    </div>
                    <div class="strength-label mt-1" id="strengthText">Password Strength: Minimum 6 characters</div>
                    <p class="err text-center" id="ChangePwd-password" style="display: none;"></p>
                </div>

                <div class="luxury-field mt-3">
                    <label for="password_confirmation">Confirm New Password <span>*</span></label>
                    <div class="field-with-icon password-toggle-wrap">
                        <i class="fa-solid fa-check-double"></i>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Repeat your new password">
                        <button type="button" class="pass-toggle-btn" onclick="togglePassVisibility('password_confirmation', this);" title="Toggle visibility">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                    <p class="err text-center" id="ChangePwd-password_confirmation" style="display: none;"></p>
                </div>

                <div class="password-guidelines-box mt-3">
                    <h6><i class="fa-solid fa-circle-info"></i> Password Guidelines:</h6>
                    <ul>
                        <li id="rule-len"><i class="fa-regular fa-circle-dot"></i> Minimum 6 characters in length</li>
                        <li id="rule-num"><i class="fa-regular fa-circle-dot"></i> Contains at least one number or special character</li>
                        <li id="rule-case"><i class="fa-regular fa-circle-dot"></i> Combines upper and lowercase letters</li>
                    </ul>
                </div>

                <div class="profile-actions-bar mt-4 pt-2">
                    <button type="submit" class="primary-btn security-save-btn">
                        <i class="fa-solid fa-lock"></i>
                        <span>Update Password</span>
                    </button>
                    <span id="passStatusMsg" class="save-status-msg"></span>
                </div>
            </form>
        </div>
    </div>
</div>

@section('javascript')
@parent
<script type="text/javascript" src="{{ asset('js/ajax_jquery.min.js')}}"></script>
<script>
    function togglePassVisibility(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'fa-regular fa-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'fa-regular fa-eye';
        }
    }

    function checkStrength(val) {
        const bar = document.getElementById('strengthBar');
        const text = document.getElementById('strengthText');
        const ruleLen = document.getElementById('rule-len');
        const ruleNum = document.getElementById('rule-num');
        const ruleCase = document.getElementById('rule-case');

        let score = 0;
        if (val.length >= 8) {
            score++;
            ruleLen.classList.add('met');
            ruleLen.querySelector('i').className = 'fa-solid fa-check text-success';
        } else {
            ruleLen.classList.remove('met');
            ruleLen.querySelector('i').className = 'fa-regular fa-circle-dot';
        }

        if (/\d|[!@#$%^&*]/.test(val)) {
            score++;
            ruleNum.classList.add('met');
            ruleNum.querySelector('i').className = 'fa-solid fa-check text-success';
        } else {
            ruleNum.classList.remove('met');
            ruleNum.querySelector('i').className = 'fa-regular fa-circle-dot';
        }

        if (/[a-z]/.test(val) && /[A-Z]/.test(val)) {
            score++;
            ruleCase.classList.add('met');
            ruleCase.querySelector('i').className = 'fa-solid fa-check text-success';
        } else {
            ruleCase.classList.remove('met');
            ruleCase.querySelector('i').className = 'fa-regular fa-circle-dot';
        }

        if (val.length === 0) {
            bar.style.width = '0%';
            text.innerText = 'Password Strength: Minimum 8 characters';
        } else if (score === 1) {
            bar.style.width = '33%';
            bar.style.background = '#e74c3c';
            text.innerText = 'Weak Password';
        } else if (score === 2) {
            bar.style.width = '66%';
            bar.style.background = '#f39c12';
            text.innerText = 'Moderate Password';
        } else if (score === 3) {
            bar.style.width = '100%';
            bar.style.background = '#27ae60';
            text.innerText = 'Strong Password';
        }
    }

    $("#MySettingsForm").submit(function(e) {
        e.preventDefault();

        var $btn = $('.security-save-btn');
        var origText = $btn.html();
        $btn.html('<i class="fa-solid fa-spinner fa-spin"></i> <span>Updating...</span>').prop('disabled', true);

        $('.PleaseWaitDiv').show();
        var formdata = $("#MySettingsForm").serialize();

        $.ajax({
            url: '/change-password',
            type: 'POST',
            data: formdata,
            success: function(data) {
                $('.PleaseWaitDiv').hide();

                if (!data.status) {
                    $btn.html(origText).prop('disabled', false);
                    $.each(data.errors, function(i, error) {
                        $('#ChangePwd-' + i).attr('style', 'color:red');
                        $('#ChangePwd-' + i).html(error);
                        setTimeout(function() {
                            $('#ChangePwd-' + i).css({
                                'display': 'none'
                            });
                        }, 3000);
                    });
                } else {
                    printSuccessMsg(data.message);
                    $('.print-success-msg').delay(2000).fadeOut('slow');

                    $btn.html('<i class="fa-solid fa-check"></i> <span>Password Changed!</span>');
                    $btn.css('background', '#287444');
                    $('#passStatusMsg').html('<i class="fa-solid fa-circle-check"></i> Password updated successfully.').addClass('active');

                    $("#MySettingsForm").trigger("reset");
                    $('#strengthBar').css('width', '0%');
                    $('#strengthText').text('Password Strength: Minimum 8 characters');

                    setTimeout(function() {
                        $btn.html(origText).prop('disabled', false).css('background', '');
                    }, 2500);
                }
            }
        });
    });
</script>
@stop