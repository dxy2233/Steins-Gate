<script>
  import { onMount } from "svelte";
  import init, { run } from "@/assets/wasm/bevy-alphamode/viper_bevy.js";

  onMount(async () => {
    await init();
    run();
  });
</script>

<canvas id="bevy-canvas"></canvas>

<style>
  #bevy-canvas {
    display: block;
    width: 100%;
    height: 100%;
  }
</style>
