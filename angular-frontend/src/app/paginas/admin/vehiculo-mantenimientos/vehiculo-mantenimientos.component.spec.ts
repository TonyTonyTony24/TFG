import { ComponentFixture, TestBed } from '@angular/core/testing';

import { VehiculoMantenimientosComponent } from './vehiculo-mantenimientos.component';

describe('VehiculoMantenimientosComponent', () => {
  let component: VehiculoMantenimientosComponent;
  let fixture: ComponentFixture<VehiculoMantenimientosComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [VehiculoMantenimientosComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(VehiculoMantenimientosComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
