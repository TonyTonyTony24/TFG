import { ComponentFixture, TestBed } from '@angular/core/testing';

import { VehiculoSegurosComponent } from './vehiculo-seguros.component';

describe('VehiculoSegurosComponent', () => {
  let component: VehiculoSegurosComponent;
  let fixture: ComponentFixture<VehiculoSegurosComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [VehiculoSegurosComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(VehiculoSegurosComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
