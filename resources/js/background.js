//Background Slide Show

//Vegas is not a proper node module, and thus requires jQuery to be set exactly like this to work
window.jQuery = require('jquery');
require('vegas');


//See here for more options:  http://vegas.jaysalvat.com/documentation/settings/
const localSlides = [
    {src: '/img/bg/bg1.jpg'},
    {src: '/img/bg/bg2.jpg'},
    {src: '/img/bg/bg3.jpg'},
];

const remoteSlides = [
    //These are all free (at least non-commercial) use images or images in the public domain
    {src: 'https://upload.wikimedia.org/wikipedia/commons/d/d6/San_Francisco_International_Airport_at_night.jpg'},     //Andrew Choy from Santa Clara, California (Creative Commons Attribution-Share Alike 2.0 Generic)
    {src: 'https://upload.wikimedia.org/wikipedia/commons/6/62/Starsinthesky.jpg'},    //Credit ESA (This is me giving credit, per the license)
    {src: 'https://upload.wikimedia.org/wikipedia/commons/0/00/Crab_Nebula.jpg'},                  //Credit NASA
    {src: 'https://upload.wikimedia.org/wikipedia/commons/7/7f/Ngc1999.jpg'},                      //Credit NASA
    {src: 'https://upload.wikimedia.org/wikipedia/commons/4/4e/Pleiades_large.jpg'},               //Credit NASA
    {src: 'https://upload.wikimedia.org/wikipedia/commons/c/c9/Sirius_A_and_B_artwork.jpg'},       //Credit NASA
    {src: 'https://upload.wikimedia.org/wikipedia/commons/5/57/Witness_the_Birth_of_a_Star.jpg'},  //Credit NASA
    {src: 'https://upload.wikimedia.org/wikipedia/commons/4/44/Ngc6397_hst_blue_straggler.jpg'},   //Credit NASA
    {src: 'https://upload.wikimedia.org/wikipedia/commons/b/b4/The_Sun_by_the_Atmospheric_Imaging_Assembly_of_NASA%27s_Solar_Dynamics_Observatory_-_20100819.jpg'}  //Credit NASA
];

const STORAGE_KEYS = {
    enabled: 'epcc.background.enabled',
    remoteEnabled: 'epcc.background.remoteEnabled',
};

const isMobile = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));

const readBoolSetting = (key, fallback) => {
    try {
        const value = localStorage.getItem(key);
        if (value === null) {
            return fallback;
        }
        return value === 'true';
    } catch (error) {
        return fallback;
    }
};

const buildBackgroundSlides = () => {
    const backgroundsEnabled = readBoolSetting(STORAGE_KEYS.enabled, true);
    if (!backgroundsEnabled) {
        return [{}];
    }

    const remoteDefault = !isMobile;
    const remoteEnabled = readBoolSetting(STORAGE_KEYS.remoteEnabled, remoteDefault);
    if (!remoteEnabled) {
        return localSlides;
    }

    return localSlides.concat(remoteSlides);
};

const applyBackgroundSettings = () => {
    const slides = buildBackgroundSlides();
    try {
        window.jQuery('body').vegas('destroy');
    } catch (error) {
        // Ignore destroy errors if vegas was never initialized.
    }
    window.jQuery('body').vegas({
        timer: false,
        shuffle: true,
        delay: 60000,
        overlay: overlay,
        slides: slides
    });
}

import overlay from 'vegas/src/overlays/08.png';

window.applyBackgroundSettings = applyBackgroundSettings;

export const init = () => {
    applyBackgroundSettings();
};
