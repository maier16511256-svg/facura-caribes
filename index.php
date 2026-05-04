<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="friocarib: sitio informativo sobre aires acondicionados, confort termico, mantenimiento, instalacion y uso eficiente en clima calido.">
    <meta name="keywords" content="friocarib, aire acondicionado, climatizacion, mantenimiento, instalacion, confort termico, filtros, BTU">
    <meta name="author" content="friocarib">
    <meta name="robots" content="index, follow">
    <title>friocarib | Aires acondicionados y confort termico</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --deep: #0b2435;
            --ink: #132f3f;
            --text: #4f6470;
            --muted: #78909c;
            --line: #d8e7ee;
            --paper: #f3fbfd;
            --surface: #ffffff;
            --ice: #a7f3ff;
            --blue: #0ea5e9;
            --blue-dark: #0369a1;
            --mint: #66e4c4;
            --sun: #f6c453;
            --shadow: 0 24px 70px rgba(11, 36, 53, 0.14);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            color: var(--text);
            background: var(--paper);
            line-height: 1.65;
            overflow-x: hidden;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .icon {
            display: inline-grid;
            place-items: center;
            flex: 0 0 auto;
            width: 1.5em;
            height: 1.5em;
            font: 800 0.82em/1 Consolas, "Courier New", monospace;
        }

        #preloader {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: grid;
            place-items: center;
            background: var(--paper);
            transition: opacity 0.35s ease, visibility 0.35s ease;
        }

        #preloader.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #dff4fb;
            border-top-color: var(--blue);
            border-radius: 50%;
            animation: spin 0.85s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
            padding: 1rem 6%;
