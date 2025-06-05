import { ComponentFixture, TestBed } from '@angular/core/testing';

import { VehiculoInfoComponent } from './vehiculo-info.component';

describe('VehiculoInfoComponent', () => {
  let component: VehiculoInfoComponent;
  let fixture: ComponentFixture<VehiculoInfoComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [VehiculoInfoComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(VehiculoInfoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
