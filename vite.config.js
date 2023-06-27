import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import {viteStaticCopy} from "vite-plugin-static-copy";

export default defineConfig({
    build: {
        sourcemap: true,
    },
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        viteStaticCopy({
            targets: [
                {
                    src: 'node_modules/gridstack/dist/gridstack-all.js',
                    dest: 'js'
                },
                {
                    src: 'node_modules/gridstack/dist/gridstack.min.css',
                    dest: 'css'
                },
                {
                    src: 'node_modules/gridstack/dist/gridstack-extra.min.css',
                    dest: 'css'
                },
            ]
        })
    ],
});
