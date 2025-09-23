<style>
    /* Estilos del botón de estado */
    .status-btn {
        padding: 5px 10px;
        border-radius: 20px;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 0.75rem;
        border: none;
        cursor: default;
    }

    .status-pending {
        background-color: #f44336; /* Rojo */
        color: #fff;
    }

    .status-completada {
        background-color: #4CAF50; /* Verde */
        color: #fff;
    }

    .status-cancelada {
        background-color: #757575; /* Gris */
        color: #fff;
    }

    /* Estilos para las tareas canceladas */
    .task-item.cancelada {
        background-color: #424242; /* Gris oscuro para el fondo del ítem */
        opacity: 0.7; /* Para que se vea más tenue */
        pointer-events: none; /* Deshabilitar clics */
    }

    .task-item.cancelada .task-info,
    .task-item.cancelada .task-icon,
    .task-item.cancelada .task-actions {
        filter: grayscale(100%); /* Poner en escala de grises */
    }
</style>

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
                            <!-- Botón de estado dinámico -->
                            <button class="status-btn status-<?php echo $status_class; ?>">
                                <i class="fas fa-calendar"></i> <?php echo htmlspecialchars($tarea['ESTADO_TAREA']); ?>
                            </button>
                        </div>
                    </div>
                    <div class="task-actions">
                        <?php if ($tarea['ESTADO_TAREA'] === 'PENDIENTE'): ?>
                            <button class="task-action-btn complete-btn" onclick="completeTask(<?php echo $tarea['ID_TAREA']; ?>)">
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const APP_URL = "<?php echo \config\APP_URL; ?>";
</script>
    <?php if (isset($_SESSION['rolClasificacion']) && $_SESSION['rolClasificacion'] === 'EMPLEADO'): ?>
        <script src="<?php echo \config\APP_URL; ?>public/js/tarea/motrarTareasEmpleado.js"></script>
    <?php endif; ?>