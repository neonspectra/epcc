const STORAGE_KEY = 'epcc.theme.mode';
const DEFAULT_MODE = 'dark';

const getStoredMode = () => {
    try {
        return localStorage.getItem(STORAGE_KEY);
    } catch (error) {
        return null;
    }
};

const normalizeMode = (mode) => (mode === 'light' ? 'light' : 'dark');

const applyTheme = (mode) => {
    const theme = normalizeMode(mode);
    document.documentElement.setAttribute('data-theme', theme);
};

const applyThemeSettings = () => {
    const stored = getStoredMode();
    applyTheme(stored || DEFAULT_MODE);
};

const setThemeMode = (mode) => {
    try {
        localStorage.setItem(STORAGE_KEY, normalizeMode(mode));
    } catch (error) {
        // Ignore storage errors.
    }
    applyTheme(mode);
};

window.applyThemeSettings = applyThemeSettings;
window.setThemeMode = setThemeMode;

export const init = () => {
    applyThemeSettings();
};
