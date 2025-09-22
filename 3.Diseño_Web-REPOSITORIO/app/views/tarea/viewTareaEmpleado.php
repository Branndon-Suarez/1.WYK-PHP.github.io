<div id="tareas-content">
    <div class="card">
        <h2>Mis Tareas</h2>
        <?php if (!empty($tareas)): ?>
            <ul class="task-list">
                <?php foreach ($tareas as $tarea): ?>
                    <li class="task-item">
                        <div class="task-details">
                            <h3><?php echo htmlspecialchars($tarea['TAREA']); ?></h3>
                            <p><?php echo htmlspecialchars($tarea['DESCRIPCION']); ?></p>
                            <span class="task-category"><?php echo htmlspecialchars($tarea['CATEGORIA']); ?></span>
                        </div>
                        <div class="task-meta">
                            <span class="task-priority priority-<?php echo strtolower($tarea['PRIORIDAD']); ?>"><?php echo htmlspecialchars($tarea['PRIORIDAD']); ?></span>
                            <span class="task-status status-<?php echo strtolower($tarea['ESTADO_TAREA']); ?>"><?php echo htmlspecialchars($tarea['ESTADO_TAREA']); ?></span>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No tienes tareas asignadas por el momento.</p>
        <?php endif; ?>
    </div>
</div>