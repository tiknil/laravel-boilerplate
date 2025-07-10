<x-frontend::layouts.page title="Homepage">
  <div class="content p-md" style="line-height: 1.5;">
  
    Nella sezione frontend, sono predisposti dei file scss personalizzabile 
    che presentano il punto di partenza per un tema <i>completamente personalizzabile</i> 
    e <i>comodo</i> da usare nello sviluppare la UI. <br /> <br />

    L'idea alla base è avere delle classi di utility comode per lo stile di base, e creare poi i componenti ad-hoc per gli elementi più complessi.
    <br /> <br />
    <b>Tutto quanto è personalizzabile</b> tramite variabili css, che sono tutte raggruppate nel file <code>resources/css/frontend/_vars.scss</code>.
    <br />
    Nel file <code>resources/css/frontend/_utils.scss</code> vengono generate tutte le classi di utility.
    
    <h3>Colori</h3>
    Nelle variabili sono impostate delle palette di colori di base, prese da <a href="https://www.tailwindcss.com/docs/colors" target="_blank">Tailwind</a>.
    <br />
    Con questi, si impostano poi vari colori da usare nella nostra UI: border, background, text,  text-muted, primary ecc ecc.

    Per ogni colore UI si generano delle classi di utility bg-{colore}, text-{colore}, border-{colore} e svg-{colore} che possono essere usate per impostare il colore di sfondo, del testo, del bordo o di un'icona SVG. <br />
    <div class="flex-row g-lg">
      <span>Esempio: </span>
      <span class="bg-primary text-light">bg-primary</span> 
      <span class="bg-green">bg-green</span> 
      <span class="bg-red">bg-red</span> 

      <span class="bg-white">bg-white</span> 
      <span class="bg-background">bg-background</span> 
      <span class="bg-light">bg-light</span> 
      <span class="bg-muted">bg-muted</span> 
      <span class="bg-black text-light">bg-black</span> 
    
    </div>

    <h3>Bottoni</h3>

    Nel file <code>resources/css/frontend/components/bottons.scss</code>
  
    <div class="flex-row align-items-start g-md mt-md">
      <button class="btn">btn</button>
      <button class="btn btn-primary">btn btn-primary</button>
      <button class="btn btn-green">btn btn-green</button>
      <button class="btn btn-red">btn btn-red</button>
      <button class="btn btn-sm">btn btn-sm</button>
    </div>

    <h3>Inputs</h3>
    Nel file <code>resources/css/frontend/components/inputs.scss</code>

    <div class="flex-row align-items-start g-md mt-md">
      <div class="flex">
        <label for="">Input</label>
        <input type="text" class="form-control" placeholder="classe form-control" />
      </div>

      <div class="flex">
        <label for="">Select</label>
        <select class="form-control">
          <option>classe form-control</option>
          <option>Option 2</option>
        </select>
      </div>
    </div>


    <h3>Responsiveness</h3>
    Nel file <code>resources/css/frontend/_layout.scss</code>. <br /> <br />
  
    Sono predisposti breakpoint, classi e mixin sass per semplificare la gestione di UI responsive.
    Le dimensioni predisposte sono 
    <code>xs</code>, <code>sm</code>, <code>md</code>, <code>lg</code> e <code>xl</code>. <br />

    Ogni dimensione ha delle classi utility per mostrare / nascondere gli elementi in base alla dimensione dello schermo: <br />
    <ul>
      <li>
        <code>$dim-only</code>: Elemento visualizzato solo nel range della dimensione indicata (es. sm-only visualizza l'elemento solo in sm)
      </li>
      <li>
        <code>$dim-up</code>: Elemento visualizzato solo dalla dimensione indicata in su (es. md-up visualizza l'elemento in md, lg e xl)
      </li>
      <li>
        <code>$dim-down</code>: Elemento visualizzato solo dalla dimensione indicata in giù (es. sm-down visualizza l'elemento in sm e xs)
      </li>
    </ul>

    Ad ognuna di queste classi corrisponde anche un mixin, utilizzabile all'interno degli altri file scss per aggiungere stili personalizzati nel range indicato:
    <pre class="mb-xxs">
      {!! '@' !!}use 'layout' // Ad inizio file scss, importare il file _layout.scss
      
      #homepage {
        {!! '@' !!}include layout.sm-down { 
          // Stili applicati ad #homepage solo in sm e xs
        }
      }</pre>

    <h3>Spaziature</h3>
    Le dimensione dei vari elementi sono tipicamente impostate con l'unità di misura rem, che corrisponde alla dimensione del testo del body. 
    Questo permette, volendo, di variare la dimensione del testo per diverse dimensioni di schermo e avere tutto il resto "scalare" correttamente in automatico. <br />
    <br />
    Sono predisposte 6 spaziature di default da utilizzare per margini , padding e simili: <code>xxs, xs, sm, md, lg e xl</code>. <br />
    Per ogni dimensione, oltre alla variabile css relativa (<code>var(--spacing-sm)</code>), sono predisposte delle classi utility per applicare margini e padding.<br />

    La prima lettera indica il padding (p) o il margine (m), seguita dalla direzione: t (top), b (bottom), l (left), r (right), h (horizontal, left e right) e v (vertical, top e bottom). In seguito la spaziatura da applicare<br />
    es. p-xs -> padding extra small, mh-md -> margine orizzontale medio, pt-lg -> padding top largo, ecc.
    <div class="flex-row g-lg mv-md">

      <div class="flex-row align-items-start border-border">
        <span class="p-xs border-primary">p-xs</span>
        <span class="pt-sm border-primary">pt-sm</span>
        <span class="pv-md border-primary">pv-md</span>
        <span class="pe-lg border-primary">pe-lg</span>
        <span class="ph-xl border-primary">ph-xl</span>
      </div>

      <div class="flex-row align-items-start border-border">
        <span class="m-xs border-primary">m-xs</span>
        <span class="mt-sm border-primary">mt-sm</span>
        <span class="mv-md border-primary">mv-md</span>
        <span class="mh-lg border-primary">mh-lg</span>
        <span class="me-xl border-primary">me-xl</span>
      </div>
    </div>

    Con g-$dim invece si imposta il gap, per i layout flex e grid:

      <div class="flex-row g-xl mv-md">
        <div class="flex-row align-items-start g-sm border-border">
          <span class="border-primary">g-sm</span>
          <span class="border-primary">g-sm</span>
          <span class="border-primary">g-sm</span>
        </div>

        <div class="flex-row g-lg align-items-start border-border">
          <span class="border-primary">g-lg</span>
          <span class="border-primary">g-lg</span>
          <span class="border-primary">g-lg</span>
        </div>
      </div>
   

    <h3>Testi</h3>
    Il font definito in <code>_vars.scss</code> viene importato tramite google fonts e impostato come font della pagine.
    <br /> <br /> 
    <div class="flex-row g-lg">
      <span>Colori: </span>
      <span class="text-muted">text-muted</span> 
      <span class="text-green">text-green</span> 
      <span class="text-red">text-red</span> 
      <span class="text-primary">text-primary</span> 
      <span class="text-background">text-background</span>
    </div>
    <div class="flex-row g-lg">
      <span>Font weight: </span>
      <span class="fw-l">fw-l</span> 
      <span class="fw-r">fw-r</span> 
      <span class="fw-m">fw-m</span> 
      <span class="fw-sb">fw-sb</span> 
      <span class="fw-b">fw-b</span>
    </div>
    <div class="flex-row g-lg">
      <span>Dimensione: </span>
      <span class="text-sm">text-sm</span> 
      <span class="text-base">text-base</span> 
      <span class="text-lg">text-lg</span> 
      <span class="text-xl">text-xl</span>
    </div>
    <div class="flex-row g-lg">
      <span>Allineamento: </span>
      <span class="border-border text-start" style="width: 200px">text-start</span>
      <span class="border-border text-center" style="width: 200px">text-center</span>
      <span class="border-border text-end" style="width: 200px">text-end</span>
    </div>
    <div class="mt-md ellipse border-border" style="max-width: 350px">con <code>ellipse</code> puoi limitare la lunghezza massima</div>

    <h3>Flex</h3>
    Alcune classe di utility permettono di creare rapidamente dei layout flex basilari:
    <ul>
      <li><code>d-flex</code>: imposta display: flex</li>
      <li><code>flex-row</code>: imposta display: flex e direzione row</li>
      <li><code>flex-row</code>: imposta display: flex e direzione row</li>
      <li><code>flex</code>: imposta flex: 1</li>
      <li><code>justify-content-center</code> e simili per impostare il justify-content</li>
      <li><code>align-items-center</code> e simili per impostare l'align-items</li>
    </ul>
  </div>
</x-frontend::layouts.page>
