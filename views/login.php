<?php $this->layout('layouts::app', ['title' => 'Login']) ?>

@section('content')
<div style="max-width: 400px; margin: 100px auto; padding: 2rem; background: white; border-radius: 10px; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
    <h2 style="text-align: center;">Login</h2>
    
    <?php if (isset($error)): ?>
        <div style="background: #fee; color: #c33; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">
            <?= $this->e($error) ?>
        </div>
    <?php endif; ?>
    
    <form method="POST">
        <div style="margin-bottom: 1rem;">
            <label>Name:</label>
            <input type="text" name="name" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;">
        </div>
        <div style="margin-bottom: 1.5rem;">
            <label>Password:</label>
            <input type="password" name="password" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;">
        </div>
        <button type="submit" name="login" style="width: 100%; padding: 12px; background: #28a745; color: white; border: none; border-radius: 5px;">Login</button>
    </form>
</div>
@endsection
