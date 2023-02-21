// assets/bootstrap.js

import { startStimulusApp } from '@symfony/stimulus-bridge';
import { registerVueControllerComponents } from '@symfony/ux-vue';

// Registers Stimulus controllers from controllers.json and in the controllers/ directory
export const app = startStimulusApp(require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!@/controllers',
    true,
    /\.[jt]sx?$/
));

// register any custom, 3rd party controllers here
// app.register('some_controller_name', SomeImportedController);

// Registers Vue.js controller components to allow loading them from Twig
registerVueControllerComponents(require.context('./vue/controllers', true, /\.vue$/));

// If you prefer to lazy-load your Vue.js controller components, in order to reduce to keep the JavaScript bundle the smallest as possible,
// and improve performances, you can use the following line instead:
//registerVueControllerComponents(require.context('./vue/controllers', true, /\.vue$/, 'lazy'));
