function setTheme(themeName) { //This script handles the site themes and music.
    document.body.classList.remove('theme-halloween', 'theme-christmas');
    document.body.classList.add(themeName);
    localStorage.setItem('theme', themeName);

    const audio = document.getElementById('bg-music');
    const musicMap = {
        'theme-default': 'audio/main.mp3',
        'theme-halloween': 'audio/halloween.mp3',
        'theme-christmas': 'audio/theme-christmas.mp3'
    };
    const musicSrc = musicMap[themeName] || musicMap['theme-default'];
    if (audio) {
        audio.src = musicSrc;
        audio.play().catch(() => { });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const audio = document.getElementById('bg-music');
    const muteButton = document.getElementById('mute-toggle');

    const savedTheme = localStorage.getItem('theme') || 'theme-default';
    document.body.classList.add(savedTheme);

    if (audio) {
        const musicMap = {
            'theme-default': 'audio/main.mp3',
            'theme-halloween': 'audio/halloween.mp3',
            'theme-christmas': 'audio/theme-christmas.mp3'
        };
        const musicSrc = musicMap[savedTheme];
        audio.src = musicSrc;
        audio.volume = 0.05;
        audio.muted = localStorage.getItem('muted') === 'true';

        audio.play().catch(() => { });
    }

    if (muteButton && audio) {
        muteButton.textContent = audio.muted ? 'volume_off' : 'volume_up';
        muteButton.addEventListener('click', () => {
            audio.muted = !audio.muted;
            localStorage.setItem('muted', String(audio.muted));
            muteButton.textContent = audio.muted ? 'volume_off' : 'volume_up';
        });
    }
});
