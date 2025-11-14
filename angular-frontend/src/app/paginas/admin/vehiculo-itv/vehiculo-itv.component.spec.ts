import { ComponentFixture, TestBed } from '@angular/core/testing';

import { VehiculoItvComponent } from './vehiculo-itv.component';

describe('VehiculoItvComponent', () => {
  let component: VehiculoItvComponent;
  let fixture: ComponentFixture<VehiculoItvComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [VehiculoItvComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(VehiculoItvComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
