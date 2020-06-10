<?php $__env->startSection('css'); ?>
<style>
    #fig1,#fig3,
    #fig2 {
        float: left;
        width: 220px;
        height: 220px;
        margin: 20px;
        padding: 20px;
        border: 2px solid blue;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php if(session('status')): ?>
<div class="alert alert-success" role="alert">
    <?php echo e(session('status')); ?>

</div>
<?php endif; ?>



<p>Drag Doggo between these the two elements.</p>

<div id="fig1"
    ondrop="dropThis(event)" ondragover="allowDropThis(event)">
    <img src="https://cdn.bitdegree.org/learn/pom-laptop.png?raw=true"
    draggable="true" ondragstart="dragThis(event)"
        id="drag1" width="220" height="220">
</div>
<div id="fig3"
    ondrop="dropThis(event)" ondragover="allowDropThis(event)">
    <span class="border border-danger" draggable="true" ondragstart="dragThis(event)"
        id="drag3">device x</span>
</div>
<div id="fig4"
    ondrop="dropThis(event)" ondragover="allowDropThis(event)">
    <span class="border border-danger" draggable="true" ondragstart="dragThis(event)"
        id="drag4">device z</span>
</div>

cercay
<div id="fig2" class="border border-success" ondrop="dropThis(event)" ondragover="allowDropThis(event)"></div>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>

<script>
    function allowDropThis(i) {
        i.preventDefault();
    }

    function dragThis(i) {
        i.dataTransfer.setData("doggo", i.target.id);
    }

    function dropThis(i) {
        i.preventDefault();
        var data = i.dataTransfer.getData("doggo");
        i.target.appendChild(document.getElementById(data));
    }

</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.adm', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/fencybot/resources/views/drag/index.blade.php ENDPATH**/ ?>