/**
 *  @author Eugene Terentev <eugene@terentev.net>
 */
$.material.init();

function generatePassword() {
    if (window.crypto.getRandomValues === 'undefined') {
        alert("Your browser doesn't defend a generator of cryptographically secure random numbers.We " +
            "can't generate secure password.");
    } else {
        var genPassword = "";

        //A generator of cryptographically secure random numbers

        var numPassword = new Uint8Array(12);
        window.crypto.getRandomValues(numPassword);

        //Transform random numbers to ascii symbols from #33 to #126

        var interval = 256 / 94;
        var asciiNumber = 0;

        for (var i = 0; i < numPassword.length; i++) {
            asciiNumber = Math.floor((numPassword[i]) / interval) + 33;
            genPassword += String.fromCharCode(asciiNumber);
        }
        return genPassword;
    }
}