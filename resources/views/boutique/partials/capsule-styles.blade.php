<style>
    .capsule-page { max-width: 1100px; margin: 0 auto; padding: 20px 0 60px; }
    .capsule-page-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 46px; align-items: start; }
    .cp-principale { aspect-ratio: 4/5; background: var(--blanc-chaud); border: 1px solid var(--ligne); overflow: hidden; border-radius: 4px; }
    .cp-principale img { width: 100%; height: 100%; object-fit: cover; }
    .cp-miniatures { display: flex; gap: 10px; margin-top: 10px; flex-wrap: wrap; }
    .cp-miniatures img { width: 76px; height: 76px; object-fit: cover; border: 1px solid var(--ligne); border-radius: 3px; cursor: pointer; transition: border-color .2s; }
    .cp-miniatures img:hover { border-color: var(--or); }
    .cp-texte h1 { font-family: 'Fraunces', serif; font-size: clamp(30px, 4.5vw, 46px); font-weight: 300; margin: 6px 0 20px; }
    .cp-texte p { font-size: 15px; line-height: 1.9; color: #5c5346; margin-bottom: 18px; }

    .cp-note { background: var(--blanc-chaud); border: 1px solid var(--ligne); border-left: 3px solid var(--or); padding: 16px 18px; margin: 22px 0; }
    .cp-badge { display: inline-block; background: var(--noir); color: var(--or-clair); font-size: 11px; letter-spacing: .12em; text-transform: uppercase; padding: 5px 11px; margin-bottom: 10px; }
    .cp-note p { font-size: 13.5px; line-height: 1.75; color: var(--gris); margin: 0; }

    .cp-actions { display: flex; gap: 12px; margin-top: 26px; flex-wrap: wrap; }
    @media (max-width: 780px) {
        .capsule-page-grid { grid-template-columns: 1fr; gap: 26px; }
    }
</style>
