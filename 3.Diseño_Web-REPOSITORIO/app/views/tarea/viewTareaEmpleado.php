<div class="card-body">
    <!-- Barra de progreso general -->
    <div class="progress-overview">
        <div class="progress-bar">
            <div class="progress-fill" id="progressFill" style="width: 0%"></div>
        </div>
        <div class="progress-text">
            <span>Progreso general</span>
            <span id="progressText">0%</span>
        </div>
    </div>

    <div class="timeline" id="taskTimeline">
        <?php if (!empty($tareas)): ?>
            <?php foreach ($tareas as $tarea): ?>
                <?php
                $status_class = strtolower($tarea['ESTADO_TAREA']);
                $dot_class = 'dot-' . $status_class;
                $is_cancelled = ($status_class === 'cancelada');
                ?>
                <div class="timeline-item">
                    <div class="timeline-dot <?php echo $dot_class; ?>"></div>
                    <div class="task-item <?php echo $status_class; ?>" data-task-id="<?php echo $tarea['ID_TAREA']; ?>">
                        <div class="task-icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <div class="task-info">
                            <div class="task-name"><?php echo htmlspecialchars($tarea['TAREA']); ?></div>
                            <div class="task-description"><?php echo htmlspecialchars($tarea['DESCRIPCION']); ?></div>
                            <div class="task-meta">
                                <span><i class="fas fa-clock"></i> <?php echo htmlspecialchars($tarea['TIEMPO_ESTIMADO_HORAS']); ?> hora<?php echo ($tarea['TIEMPO_ESTIMADO_HORAS'] != 1) ? 's' : ''; ?></span>
                                <button class="status-btn status-<?php echo $status_class; ?>">
                                    <i class="fas fa-calendar"></i> <?php echo htmlspecialchars($tarea['ESTADO_TAREA']); ?>
                                </button>
                            </div>
                        </div>
                        <div class="task-actions">
                            <?php if ($tarea['ESTADO_TAREA'] === 'PENDIENTE'): ?>
                                <button class="task-action-btn" onclick="completeTask(<?php echo $tarea['ID_TAREA']; ?>)">
                                    <i class="fas fa-check"></i>
                                </button>
                            <?php elseif ($tarea['ESTADO_TAREA'] === 'COMPLETADA'): ?>
                                <button class="task-action-btn undo-btn" onclick="undoTask(<?php echo $tarea['ID_TAREA']; ?>)">
                                    <i class="fas fa-undo"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center; color: var(--text-secondary);">No tienes tareas asignadas por el momento.</p>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const APP_URL = "<?php echo \config\APP_URL; ?>";
</script>
<?php if (isset($_SESSION['rolClasificacion']) && $_SESSION['rolClasificacion'] === 'EMPLEADO'): ?>
    <script src="<?php echo \config\APP_URL; ?>public/js/tarea/motrarTareasEmpleado.js"></script>
<?php endif; ?>